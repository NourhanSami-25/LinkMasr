document.addEventListener("DOMContentLoaded", function () {
    const chatToggle = document.getElementById("kt_drawer_chat_toggle");
    if (chatToggle) {
        chatToggle.addEventListener("click", function () {
            fetch('/todosget')
                .then(response => response.json())
                .then(data => {
                    let todoListContainer = document.querySelector("[data-kt-element='messages']");
                    todoListContainer.innerHTML = "";

                    data.forEach(todo => {
                        let priorityClass = getPriorityColor(todo.priority);
                        let statusClass = getStatusColor(todo.status);

                        let todoBlock = `
                        <div class="mb-10 rounded-4 shadow-sm bg-light p-5 border border-gray-200">
                            <div class="d-flex justify-content-between align-items-start cursor-pointer py-2"
                                 data-bs-toggle="collapse" data-bs-target="#todo-${todo.id}" 
                                 aria-expanded="false" aria-controls="todo-${todo.id}">
                                            
                                <!-- Left: Subject + Description -->
                                <div class="flex-grow-1">
                                    <span class="fs-4 fw-bold text-gray-900 text-hover-primary">${todo.subject}</span>
                                    <div class="text-muted fs-7 mt-1">${todo.description}</div>
                                </div>
                                            
                                <!-- Right: Priority + Status + Arrow -->
                                <div class="d-flex flex-column align-items-end">
                                    <div class="mb-1">
                                        <span class="badge ${priorityClass} badge-sm text-uppercase me-1">${todo.priority}</span>
                                        <span class="badge ${statusClass} badge-sm text-uppercase">${todo.status}</span>
                                    </div>
                                    <i class="ki-outline ki-down fs-2 text-muted"></i>
                                </div>
                            </div>

                            <div class="collapse mt-5" id="todo-${todo.id}">
                                ${todo.todo_items.map(item => `
                                    <div class="d-flex justify-content-start mb-5" data-item-id="${item.id}">
                                        <div class="form-check form-check-custom form-check-solid me-2">
                                            <input class="form-check-input"
                                                   type="checkbox" value="" ${item.status === 'completed' ? 'checked' : ''}
                                                   data-kt-element="checkbox" />
                                        </div>
                                        <div class="d-flex flex-column align-items-start w-100">
                                            <div class="p-5 rounded bg-light-secondary text-gray-900 fw-semibold mw-lg-400px text-start">
                                                <div class="fs-5 fw-bold text-hover-primary me-1">
                                                    ${item.subject}
                                                </div>
                                                <span class="text-muted fs-7 mb-1">${formatDate(item.date)}</span>
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                            
                            ${todo.status !== 'completed' ? `
                                <div class="d-flex flex-column align-items-end mt-5">
                                    <div class="mb-0">
                                        <a href="/todos/${todo.id}/toggle-status" class="btn btn-flex btn-primary btn-sm h-30px fs-8 fw-bold">Mark as Completed</a>
                                    </div>
                                </div>
                            ` : ''}

                            ${todo.status !== 'pending' ? `
                                <div class="d-flex flex-column align-items-end mt-5">
                                    <div class="mb-0">
                                        <a href="/todos/${todo.id}/toggle-status" class="btn btn-flex btn-primary btn-sm h-30px fs-8 fw-bold">Mark as Pending</a>
                                    </div>
                                </div>
                            ` : ''}


                        </div>
                    `;

                        todoListContainer.insertAdjacentHTML("beforeend", todoBlock);
                        // Attach event listeners to the new checkboxes
                        document.querySelectorAll("[data-kt-element='checkbox']").forEach((checkbox) => {
                            checkbox.addEventListener("change", function () {
                                const isChecked = this.checked;
                                const itemId = this.closest('.d-flex').getAttribute('data-item-id');

                                if (itemId) {
                                    fetch(`/todo-items/${itemId}/toggle-status`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            status: isChecked ? 'completed' : 'pending'
                                        })
                                    })
                                        .then(response => {
                                            if (!response.ok) throw new Error('Status update failed.');
                                            return response.json();
                                        })
                                        .then(data => {
                                            console.log('Updated:', data.message);
                                        })
                                        .catch(error => {
                                            console.error('Error updating status:', error);
                                            this.checked = !isChecked;
                                        });
                                }
                            });
                        });

                    });
                })
                .catch(error => console.error("Error fetching todos:", error));
        });
    }
});


function getPriorityColor(priority) {
    switch (priority.toLowerCase()) {
        case 'urgent': return 'badge-danger';
        case 'important': return 'badge-warning';
        case 'normal': return 'badge-success';
        default: return 'badge-secondary';
    }
}

function getStatusColor(status) {
    switch (status.toLowerCase()) {
        case 'pending': return 'badge-primary';
        case 'completed': return 'badge-success';
        default: return 'badge-secondary';
    }
}

function formatDate(dateString) {
    let date = new Date(dateString);
    return date.toLocaleDateString() + " " + date.toLocaleTimeString();
}

