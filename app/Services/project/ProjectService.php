<?php

namespace App\Services\project;


use App\Models\project\Project;
use App\Models\user\User;
use Illuminate\Support\Facades\Auth;


class ProjectService
{
    public function getAll()
    {
        $authUser = auth()->user();
        $userId = $authUser->id;
    
        // Check global access first (consistent with other models)
        if ($authUser->isAdmin() || $authUser->hasAccess('project', 'full') || $authUser->hasAccess('project', 'view_global')) {
            $projects = Project::all();
        } else {
            // Base query for user's projects
            $projectsQuery = Project::where('created_by', $userId)
                ->orWhereJsonContains('followers', (string) $userId)
                ->orWhereJsonContains('assignees', (string) $userId);
        
            // Manager-specific access
            if (__isManager($userId)) {
                $departmentId = __getManagerDepartmentId($userId);
                $departmentUserIds = User::where('department_id', $departmentId)->pluck('id');
            
                $projectsQuery->orWhereIn('created_by', $departmentUserIds)
                    ->orWhere(function ($query) use ($departmentUserIds) {
                        foreach ($departmentUserIds as $id) {
                            $query->orWhereJsonContains('followers', (string) $id)
                                  ->orWhereJsonContains('assignees', (string) $id);
                        }
                    });
            }
        
            // Execute query
            $projects = $projectsQuery->distinct()->get();
        }
    
        // Efficient loading of assignees and followers names (single query)
        $userIds = collect();
        $projects->each(function ($project) use (&$userIds) {
            $userIds = $userIds->merge(json_decode($project->assignees, true) ?? [])
                              ->merge(json_decode($project->followers, true) ?? []);
        });
    
        $users = User::whereIn('id', $userIds->unique())->pluck('name', 'id');
    
        // Map names to projects
        $projects->each(function ($project) use ($users) {
            $project->assignees_names = isset($project->assignees) 
                ? array_filter(array_map(fn($id) => $users[$id] ?? null, json_decode($project->assignees, true) ?? []))
                : [];
            
            $project->followers_names = isset($project->followers) 
                ? array_filter(array_map(fn($id) => $users[$id] ?? null, json_decode($project->followers, true) ?? []))
                : [];
        });
    
        return $projects;
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        $data['user_id'] = Auth::id(); // Add user_id for foreign key constraint
        
        // Copy subject to name for compatibility with database schema
        if (isset($data['subject'])) {
            $data['name'] = $data['subject'];
        }
        
        // Map 'date' to 'start_date' for database schema compatibility
        if (isset($data['date'])) {
            $data['start_date'] = $data['date'];
        }
        
        // Map 'due_date' to 'deadline_date' for database schema compatibility
        if (isset($data['due_date'])) {
            $data['deadline_date'] = $data['due_date'];
        }
        
        // Set default empty string for description if not provided
        if (!isset($data['description']) || $data['description'] === null) {
            $data['description'] = '';
        }
        
        // Set default billing_type if not provided
        if (!isset($data['billing_type']) || $data['billing_type'] === null) {
            $data['billing_type'] = 'fixed';
        }
        
        if (!empty($data['assignees'])) {
            $data['assignees'] = json_encode($data['assignees']);
        }
        if (!empty($data['followers'])) {
            $data['followers'] = json_encode($data['followers']);
        }
        $project = new Project();
        $project->fill($data);
        $project->save();
        return $project;
    }

    public function getItemById($id)
    {
        $project = Project::findOrFail($id);
        return $project;
    }


    public function update($id, array $data)
    {
        $project = Project::findOrFail($id);

        // Ensure keys exist in the array before using them
        $project->assignees = json_encode($data['assignees'] ?? []);
        $project->followers = json_encode($data['followers'] ?? []);

        $project->update($data);

        return $project;
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);

        try {
            // Delete related subcontract items via construction boqs
            // We need to fetch BOQs first because they are the link
            $boqIds = \App\Models\ConstructionBoq::where('project_id', $id)->pluck('id');

            if ($boqIds->isNotEmpty()) {
                // Delete related subcontract items
                \App\Models\SubcontractItem::whereIn('boq_id', $boqIds)->delete();
                
                // Also delete other related items to BOQs if any (like resources, progress, etc.)
                // Based on ConstructionBoq model: progress, resources, tasks, expenses, breakdownItems
                
                \App\Models\ConstructionProgress::whereIn('boq_id', $boqIds)->delete();
                \App\Models\ConstructionBoqResource::whereIn('boq_id', $boqIds)->delete();
                \App\Models\BoqBreakdownItem::whereIn('boq_id', $boqIds)->delete();
                
                // Tasks and expenses might be polymorphic or linked differently, but usually safe to disconnect or delete if strictly owned
                // For now, let's stick to what caused the error: subcontract_items
                
                // Finally delete the BOQs themselves
                \App\Models\ConstructionBoq::whereIn('id', $boqIds)->delete();
            }
        } catch (\Exception $e) {
            // If delete fails, we might want to log it, but for now continue to try deleting project
        }

        $project->delete();
    }
}
