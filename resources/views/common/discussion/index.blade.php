@if ($discussion)
<div id="discussion-container" data-discussion-id="{{ $discussion->id }}" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold my-2">{{__('general.discussion_panel')}}
            </div>
        </div>
    
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            <div id="discussion-messages" class="scroll-y" data-discussion-id="{{ optional($discussion)->id }}">
                <div id="no-messages-placeholder" class="text-center text-muted py-15 fs-2 fw-bold">
                    {{ __('general.no_messages_yet') }}
                </div>                
            </div>  
        </div>
    
        <div class="card-footer pt-4">
            <form id="discussion-form">
                <textarea class="form-control form-control-flush mb-3 chat-input" name="message" rows="1" placeholder="{{ __('general.type_a_message') }}"></textarea>
                <div class="d-flex flex-stack">
                    <div class="d-flex align-items-center me-2">
                        <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-1" disabled>
                           
                        </button>
                    </div>
                    <button class="btn btn-primary" type="button" id="discussion-send-btn">{{ __('general.send') }}</button>
                </div>
                <input type="hidden" name="discussion_id" value="{{ optional($discussion)->id }}">
            </form>
        </div>
    </div>
</div>

@else
<div class="card bg-light-primary mb-10 text-center py-20 px-5">
    <div class="card-body">
        <div class="mb-5">
            <i class="ki-outline ki-communication fs-1 text-primary"></i>
        </div>
        <p class="text-muted fw-semibold fs-6 mb-7">
            {{ __('general.for_some_reason_there_is_no_discussion_created') }}
        </p>
        <a href="{{ route('discussions.create', ['type' => get_class($item), 'id' => $item->id]) }}"
           class="btn btn-primary fs-3 fw-bold">
            {{ __('general.create_discussion') }}
        </a>
    </div>
</div>
@endif

<div id="deleteMessageModalContainer"></div>
