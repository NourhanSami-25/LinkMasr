document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("discussion-form");
    const messagesDiv = document.getElementById("discussion-messages");
    const discussionId = messagesDiv.dataset.discussionId;
    let lastMessageId = null;
    const renderedMessageIds = new Set();

    const renderMessage = (msg) => {
        const isMine = msg.user_id === window.userId;
        const wrapper = document.createElement("div");
        wrapper.className = `d-flex mb-10 ${
            isMine ? "justify-content-end" : "justify-content-start"
        }`;
        wrapper.setAttribute("data-message-id", msg.id);

        wrapper.innerHTML = `
            <div class="d-flex flex-column align-items-${
                isMine ? "end" : "start"
            }">
                <div class="d-flex align-items-center mb-2">
                    <div class="mx-3">
                        <div class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">${
                            msg.user.name
                        }</div>
                    </div>
                </div>
                <div class="p-5 rounded ${
                    isMine
                        ? "bg-light-primary text-end"
                        : "bg-light-info text-start"
                } text-gray-900 fw-semibold mw-lg-400px">
                    ${msg.message}
                    ${
                        isMine
                            ? `<div class="d-flex justify-content-end align-items-center gap-2 mt-3 fs-7 text-muted">
                                <span>${new Date(
                                    msg.created_at
                                ).toLocaleString()}</span>
                                <span>|</span>
                                <button data-id="${
                                    msg.id
                                }" class="btn btn-link p-0 m-0 fs-7 fw-bold text-danger delete-msg">
                                    ${i118n.deleteLabel}
                                </button>
                           </div>`
                            : `<div class="d-flex justify-content-start align-items-center gap-2 mt-3 fs-7 text-muted">
                                <span>${new Date(
                                    msg.created_at
                                ).toLocaleString()}</span>
                           </div>`
                    }
                </div>

            </div>
        `;
        return wrapper;
    };

    const loadMessages = () => {
        fetch(`/discussion-messages?discussion_id=${discussionId}`)
            .then((res) => res.json())
            .then((messages) => {
                const currentIds = new Set(messages.map((m) => m.id));
                const newMessages = [];

                messages.forEach((msg) => {
                    if (!renderedMessageIds.has(msg.id)) {
                        newMessages.push(msg);
                    }
                });

                newMessages.reverse().forEach((msg) => {
                    messagesDiv.prepend(renderMessage(msg));
                    renderedMessageIds.add(msg.id);
                });

                // Remove deleted messages
                renderedMessageIds.forEach((id) => {
                    if (!currentIds.has(id)) {
                        document
                            .querySelector(`[data-message-id="${id}"]`)
                            ?.remove();
                        renderedMessageIds.delete(id);
                    }
                });

                // Toggle "no messages" placeholder
                const placeholder = document.getElementById(
                    "no-messages-placeholder"
                );
                if (renderedMessageIds.size === 0) {
                    placeholder.style.display = "block";
                } else {
                    placeholder.style.display = "none";
                }
            });
    };

    loadMessages();
    setInterval(() => {
        loadMessages();
    }, 5000);

    document
        .getElementById("discussion-send-btn")
        .addEventListener("click", () => {
            const formData = new FormData(form);
            formData.append("discussion_id", discussionId);

            fetch("/discussion-messages", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: formData,
            }).then(() => {
                form.reset();
                loadMessages();
            });
        });

    const renderDeleteModal = (messageId) => {
        const modalId = "deleteMessageModal";
        const modalHTML = `
            <div id="${modalId}" class="modal fade" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-500px">
                    <div class="modal-content">
                        <div class="modal-header flex-stack">
                            <h2 class="w-100 text-center">${i118n.leaveTitle}</h2>
                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </button>
                        </div>
                        <div class="modal-body pb-15">
                            <p class="text-muted fs-5 fw-semibold w-100 text-center mb-10">${i118n.leaveMessage}</p>
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-danger w-100" data-delete-confirm="${messageId}" data-bs-dismiss="modal">${i118n.leaveButton}</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">${i118n.stayButton}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.getElementById("deleteMessageModalContainer").innerHTML =
            modalHTML;
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    };

    messagesDiv.addEventListener("click", function (e) {
        if (e.target.classList.contains("delete-msg")) {
            const messageId = e.target.dataset.id;
            renderDeleteModal(messageId);
        }
    });

    document.body.addEventListener("click", function (e) {
        if (e.target.matches("[data-delete-confirm]")) {
            const id = e.target.getAttribute("data-delete-confirm");
            fetch(`/discussion-messages/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            }).then(() => {
                document.querySelector(`[data-message-id="${id}"]`)?.remove();
            });
        }
    });

    loadMessages();
});
