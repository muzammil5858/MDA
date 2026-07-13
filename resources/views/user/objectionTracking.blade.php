<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Transfer Tracker | Objection Management</title>
    <!-- Bootstrap 4 + Font Awesome + jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            padding: 30px 15px;
        }
        .tracker-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.02);
            padding: 1.5rem 1rem 2rem;
            margin-bottom: 2rem;
        }
        /* Progress Steps (horizontal timeline) */
        .progress-tracker {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            position: relative;
            margin: 30px 0 20px;
        }
        .step {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 2;
            min-width: 100px;
        }
        .step:not(:first-child)::before {
            content: '';
            position: absolute;
            top: 24px;
            left: -50%;
            width: 100%;
            height: 3px;
            background-color: #e2e8f0;
            z-index: -1;
            transition: all 0.3s;
        }
        .step.completed:not(:first-child)::before,
        .step.active:not(:first-child)::before {
            background-color: #2c7da0;
        }
        .step.completed .step-icon,
        .step.active .step-icon {
            background-color: #2c7da0;
            color: white;
            border-color: #2c7da0;
        }
        .step.completed .step-icon i {
            color: white;
        }
        .step.active .step-icon {
            background-color: #ffb74d;
            border-color: #ff9800;
            box-shadow: 0 0 0 4px rgba(255,152,0,0.2);
        }
        .step.objection .step-icon {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .step-icon {
            width: 50px;
            height: 50px;
            background: #f1f5f9;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: bold;
            transition: 0.2s;
            margin-bottom: 8px;
            color: #475569;
        }
        .step-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
        }
        .step-status {
            font-size: 0.7rem;
            color: #5b6e8c;
            margin-top: 4px;
        }
        .step.objection .step-status {
            color: #dc3545;
            font-weight: 500;
        }
        /* objection panel */
        .objection-panel {
            background: #fff9ef;
            border-left: 5px solid #f4a261;
            border-radius: 1rem;
            padding: 1.25rem;
            margin-top: 1.5rem;
        }
        .objection-item {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            margin-bottom: 1.5rem;
            border: 1px solid #ffe0b5;
            transition: 0.1s;
        }
        .objection-header {
            background: #fff3e0;
            padding: 0.9rem 1.2rem;
            border-radius: 1rem 1rem 0 0;
            border-bottom: 1px solid #ffdead;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: baseline;
        }
        .badge-objection-type {
            background: #e76f51;
            color: white;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .objection-date {
            font-size: 0.75rem;
            color: #7f5539;
        }
        .objection-body {
            padding: 1rem 1.2rem;
        }
        .reply-section {
            background: #fef8ee;
            margin-top: 12px;
            padding: 12px 15px;
            border-radius: 1rem;
            border-top: 1px dashed #ffcd94;
        }
        .reply-item {
            background: white;
            border-radius: 1rem;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-left: 3px solid #8ecae6;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .reply-meta {
            font-size: 0.7rem;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .attachment-badge {
            background: #e9ecef;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 0.7rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-sm-icon {
            padding: 0.2rem 0.6rem;
            font-size: 0.75rem;
        }
        hr {
            background-color: #e2e8f0;
        }
        @media (max-width: 768px) {
            .step-icon { width: 40px; height: 40px; font-size: 1rem; }
            .step-label { font-size: 0.7rem; }
            .step:not(:first-child)::before { top: 20px; }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Main Tracker Card -->
    <div class="tracker-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <h4 class="mb-0"><i class="fas fa-exchange-alt text-primary mr-2"></i> Map Approval Progress</h4>
            <span class="badge badge-light p-2">Application #TR-2409-001</span>
        </div>
        <p class="text-muted small">Plot: P-1001 | Town: Springfield | Category: Residential</p>

        <!-- Step Tracker: 6 steps -->
        <div class="progress-tracker" id="stepTracker">
            <!-- Step 1: Request Submitted -->
            <div class="step completed" data-step="1">
                <div class="step-icon"><i class="fas fa-file-alt"></i></div>
                <div class="step-label">Request Submitted</div>
                <div class="step-status">2025-03-10</div>
            </div>
            <!-- Step 2: Approval (objection raised) -->
            <div class="step objection active" data-step="2">
                <div class="step-icon"><i class="fas fa-clipboard-list"></i></div>
                <div class="step-label">Approval</div>
                <div class="step-status"><i class="fas fa-exclamation-triangle"></i> Objection raised</div>
            </div>
            <!-- Step 3: Clerk Approval -->
            <div class="step" data-step="3">
                <div class="step-icon"><i class="fas fa-user-check"></i></div>
                <div class="step-label">Clerk Approval</div>
                <div class="step-status">Pending</div>
            </div>
            <!-- Step 4: AD Approval -->
            <div class="step" data-step="4">
                <div class="step-icon"><i class="fas fa-user-tie"></i></div>
                <div class="step-label">AD Approval</div>
                <div class="step-status">Pending</div>
            </div>
            <!-- Step 5: DD Approval -->
            <div class="step" data-step="5">
                <div class="step-icon"><i class="fas fa-stamp"></i></div>
                <div class="step-label">DD Approval</div>
                <div class="step-status">Pending</div>
            </div>
            <!-- Step 6: Request Completed -->
            <div class="step" data-step="6">
                <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                <div class="step-label">Request Completed</div>
                <div class="step-status">-</div>
            </div>
        </div>
    </div>

    <!-- Objection Management Panel (only for step 2: Approval) -->
    <div class="objection-panel" id="objectionMainPanel">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h5><i class="fas fa-gavel text-danger mr-2"></i> Objections raised on "Approval" stage</h5>
            <span class="badge badge-warning p-2">Action Required: Reply to objection(s)</span>
        </div>
        <div id="objectionsListContainer">
            <!-- objections will be injected dynamically -->
        </div>
        <!-- note: no "add objection" for user, only reply functionality -->
    </div>

    <!-- Optional info card about process -->
    <div class="alert alert-info mt-3 d-flex align-items-center" role="alert">
        <i class="fas fa-info-circle fa-lg mr-2"></i>
        <div>You can reply to each objection by adding a note and optional attachment (PDF/Image). Replies are stored locally for this session.</div>
    </div>
</div>

<script>
    // ---------- DEMO OBJECTIONS DATA ----------
    // Each objection belongs to step "Approval" (step 2)
    // Structure: { id, type, description, date, replies: [{ note, attachmentName, attachmentDataUrl? (optional), replyDate }] }
    let objectionsData = [
        {
            id: 1,
            type: "Document Mismatch",
            description: "The submitted transfer deed does not match the original registry entry. Plot dimensions discrepancy found.",
            date: "2026-04-10",
            replies: []
        }

    ];

    // Helper: format date string
    function formatDate() {
        const now = new Date();
        return now.toISOString().slice(0,10);
    }

    // Render all objections and replies
    function renderObjections() {
        const container = document.getElementById('objectionsListContainer');
        if (!container) return;
        if (objectionsData.length === 0) {
            container.innerHTML = `<div class="alert alert-success">✅ No active objections. This step is clear.</div>`;
            return;
        }

        let html = '';
        objectionsData.forEach(obj => {
            html += `
                <div class="objection-item" data-obj-id="${obj.id}">
                    <div class="objection-header">
                        <div>
                            <span class="badge-objection-type"><i class="fas fa-ban mr-1"></i> ${escapeHtml(obj.type)}</span>
                            <span class="ml-2 objection-date"><i class="far fa-calendar-alt"></i> ${obj.date}</span>
                        </div>
                        <small class="text-secondary"><i class="fas fa-hashtag"></i> #OBJ-${obj.id}</small>
                    </div>
                    <div class="objection-body">
                        <p class="mb-2"><strong>📄 Description:</strong><br> ${escapeHtml(obj.description)}</p>

                        <!-- REPLIES SECTION -->
                        <div class="replies-wrapper" id="replies-${obj.id}">
                            ${renderReplies(obj.replies)}
                        </div>

                        <!-- REPLY FORM -->
                        <div class="reply-section mt-2">
                            <form class="reply-form" data-obj-id="${obj.id}">
                                <div class="form-group">
                                    <label class="small font-weight-bold"><i class="fas fa-comment-dots"></i> Your Reply Note</label>
                                    <textarea class="form-control form-control-sm reply-note" rows="2" placeholder="Write your response to this objection..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold"><i class="fas fa-paperclip"></i> Optional Attachment</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input reply-attachment" accept=".pdf,.jpg,.jpeg,.png,.docx">
                                        <label class="custom-file-label text-truncate" style="overflow:hidden;">Choose file...</label>
                                    </div>
                                    <small class="form-text text-muted">Upload supporting document (max 5MB demo, only filename stored)</small>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary mt-1"><i class="fas fa-reply-all"></i> Submit Reply</button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;

        // Rebind file input labels and form submission
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function(e) {
                let fileName = e.target.files[0]?.name || 'Choose file...';
                let label = e.target.nextElementSibling;
                if (label) label.innerText = fileName;
            });
        });

        // Attach reply submit handlers
        document.querySelectorAll('.reply-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const objId = parseInt(form.getAttribute('data-obj-id'));
                const noteTextarea = form.querySelector('.reply-note');
                const note = noteTextarea.value.trim();
                if (!note) {
                    alert("Please enter a reply note.");
                    return;
                }
                const fileInput = form.querySelector('.reply-attachment');
                let attachmentName = null;
                if (fileInput.files.length > 0) {
                    attachmentName = fileInput.files[0].name;
                }
                // Add reply to objectionsData
                const objection = objectionsData.find(o => o.id === objId);
                if (objection) {
                    const newReply = {
                        note: note,
                        attachmentName: attachmentName,
                        attachmentDataUrl: null,
                        replyDate: formatDate()
                    };
                    objection.replies.push(newReply);
                    // re-render whole UI to show updated replies
                    renderObjections();
                    // scroll to the objection item gently
                    const targetDiv = document.querySelector(`.objection-item[data-obj-id="${objId}"]`);
                    if(targetDiv) targetDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    alert("Error: Objection not found.");
                }
            });
        });
    }

    function renderReplies(replies) {
        if (!replies || replies.length === 0) {
            return `<div class="text-muted small mb-2"><i class="far fa-comment-dots"></i> No replies yet. Use the form below to respond.</div>`;
        }
        let repliesHtml = `<div class="mb-2"><strong><i class="fas fa-history"></i> Replies (${replies.length}) :</strong></div>`;
        replies.forEach(rep => {
            repliesHtml += `
                <div class="reply-item">
                    <div class="reply-meta">
                        <i class="far fa-clock"></i> ${rep.replyDate}
                    </div>
                    <div class="mb-1">${escapeHtml(rep.note)}</div>
                    ${rep.attachmentName ? `<div class="attachment-badge mt-1"><i class="fas fa-paperclip"></i> ${escapeHtml(rep.attachmentName)}</div>` : ''}
                </div>
            `;
        });
        return repliesHtml;
    }

    // simple escape to prevent XSS
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        }).replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, function(c) {
            return c;
        });
    }

    // Additional simulation for step status: show objection badge on step 2
    function updateStepStatuses() {
        // Based on objections existence, step 2 remains objection active.
        // If all objections resolved in future (we don't auto-resolve, but just design).
        // We keep step 2 as objection active unless user manually resolves? Not needed.
        const step2Div = document.querySelector('.step[data-step="2"]');
        if (step2Div && objectionsData.length > 0) {
            step2Div.classList.add('objection');
            step2Div.classList.remove('completed');
            step2Div.classList.add('active');
            const statusSpan = step2Div.querySelector('.step-status');
            if (statusSpan) statusSpan.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Objection raised';
        } else if (objectionsData.length === 0) {
            // if no objections, step2 could become completed (demo)
            if (step2Div) {
                step2Div.classList.remove('objection', 'active');
                step2Div.classList.add('completed');
                const statusSpan = step2Div.querySelector('.step-status');
                if (statusSpan) statusSpan.innerHTML = 'Cleared ✔';
            }
        }
        // simulate first step completed already, others remain pending
        const step3 = document.querySelector('.step[data-step="3"]');
        if (step3) step3.classList.remove('completed', 'active');
        const step4 = document.querySelector('.step[data-step="4"]');
        if (step4) step4.classList.remove('completed', 'active');
        const step5 = document.querySelector('.step[data-step="5"]');
        if (step5) step5.classList.remove('completed', 'active');
        const step6 = document.querySelector('.step[data-step="6"]');
        if (step6) step6.classList.remove('completed', 'active');
    }

    // Initialize page: render objections, step status, and optional dynamic
    $(document).ready(function() {
        renderObjections();
        updateStepStatuses();

        // custom file input label fix (for dynamic added forms already handled in renderObjections)
        // also handle any extra global
        $(document).on('change', '.custom-file-input', function(e) {
            let fileName = $(this).val().split('\\').pop();
            if (fileName) $(this).next('.custom-file-label').html(fileName);
            else $(this).next('.custom-file-label').html('Choose file...');
        });

        // Demo: automatically show a small reminder toast or notification (optional)
        if (objectionsData.length > 0) {
            // Not intrusive; just additional
            console.log("Objections active - you can reply to each");
        }
    });
</script>

<!-- Extra style for custom file label -->
<style>
    .custom-file-label:after {
        content: "Browse";
    }
    .custom-file-label {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .step-icon i {
        font-size: 1.2rem;
    }
    .reply-form .form-control-sm {
        font-size: 0.8rem;
    }
    .objection-panel {
        transition: all 0.2s;
    }
    .btn-sm {
        border-radius: 2rem;
    }
    .attachment-badge i {
        margin-right: 5px;
    }
</style>

<!-- ensure that if any objection gets resolved by replying, we show the reply but objections remain (they are not auto resolved)
     However, for completeness, the officer could see all replies. In real scenario, after sufficient replies, the approval may move forward.
     This demo shows full objection management. -->
</body>
</html>
