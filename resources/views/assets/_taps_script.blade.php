<script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Function to save active tab
                    function saveActiveTab(tabId) {
                        localStorage.setItem('activeTab', tabId);
                    }
                
                    // Function to load active tab
                    function loadActiveTab() {
                        const activeTab = localStorage.getItem('activeTab');
                        if (activeTab) {
                            const tabElement = document.querySelector(`a[href="${activeTab}"]`);
                            if (tabElement) {
                                // Remove active class from all tabs first
                                document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(t => {
                                    t.classList.remove('active');
                                });
                                document.querySelectorAll('.tab-pane').forEach(p => {
                                    p.classList.remove('show', 'active');
                                });
                                
                                const tab = new bootstrap.Tab(tabElement);
                                tab.show();
                            }
                        }
                    }
                
                    // Load saved tab on page load
                    loadActiveTab();
                
                    // Save tab when a new one is shown
                    const tabLinks = document.querySelectorAll('a[data-bs-toggle="tab"]');
                    tabLinks.forEach(tabLink => {
                        tabLink.addEventListener('shown.bs.tab', function (e) {
                            const tabId = e.target.getAttribute('href');
                            saveActiveTab(tabId);
                            
                            // Remove active class from all tabs
                            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(t => {
                                t.classList.remove('active');
                            });
                            // Add active class to current tab
                            e.target.classList.add('active');
                        });
                        
                        // Handle click event to force tab activation
                        tabLink.addEventListener('click', function (e) {
                            e.preventDefault();
                            const tabId = this.getAttribute('href');
                            
                            // Remove active from all tab panes
                            document.querySelectorAll('.tab-pane').forEach(p => {
                                p.classList.remove('show', 'active');
                            });
                            // Remove active from all tab links
                            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(t => {
                                t.classList.remove('active');
                            });
                            
                            // Show current tab
                            const pane = document.querySelector(tabId);
                            if (pane) {
                                pane.classList.add('show', 'active');
                            }
                            this.classList.add('active');
                            saveActiveTab(tabId);
                        });
                    });
                });
        </script>