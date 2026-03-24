<?php
/**
 * document_type/memo.php
 * Memorandum Order form — rendered as a slide-in overlay / modal.
 * Include this file inside main.php OR load it via fetch/iframe.
 *
 * Usage in main.php:
 *   <?php include __DIR__ . '/document_type/memo.php'; ?>
 *   Then call openMemoForm() from JavaScript when the user picks "Memorandum Order".
 */

$memo_success = '';
$memo_error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_memo_submit'])) {
    $mo_number      = trim($_POST['mo_number']      ?? '');
    $date_issued    = trim($_POST['date_issued']     ?? '');
    $concerned_fac  = trim($_POST['concerned_fac']  ?? '');
    $college        = trim($_POST['college']         ?? '');
    $department     = trim($_POST['department']      ?? '');
    $subject        = trim($_POST['subject']         ?? '');
    $destination    = trim($_POST['destination']     ?? '');
    $duration       = trim($_POST['duration']        ?? '');
    $rf_number      = trim($_POST['rf_number']       ?? '');
    $source_funds   = trim($_POST['source_funds']    ?? '');
    $num_participant= trim($_POST['num_participant'] ?? '');

    if (empty($mo_number) || empty($date_issued) || empty($concerned_fac)) {
        $memo_error = 'Please fill in all required fields (MO#, Date Issued, Concerned Faculty).';
    } else {
        // TODO: save to database
        $memo_success = 'Memorandum Order submitted successfully!';
    }
}
?>

<!-- ═══════════════════════════════════════════════════════════════
     MEMO OVERLAY BACKDROP
═══════════════════════════════════════════════════════════════ -->
<div
    id="memoOverlay"
    class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm hidden transition-opacity duration-300 opacity-0"
    onclick="closeMemoForm()"
></div>

<!-- ═══════════════════════════════════════════════════════════════
     MEMO SLIDE-IN PANEL
═══════════════════════════════════════════════════════════════ -->
<div
    id="memoPanel"
    class="fixed top-0 right-0 h-full w-full max-w-2xl z-50 bg-white shadow-2xl flex flex-col
           translate-x-full transition-transform duration-300 ease-in-out"
>

    <!-- ── Panel Header ── -->
    <div class="bg-crimson-900 text-white px-6 py-5 flex items-start justify-between shrink-0">
        <div>
            <h2 class="text-xl font-bold font-main leading-tight">Memorandum Order</h2>
            <p class="text-crimson-200 text-xs mt-1 font-secondary">Fill in all required fields before submitting</p>
        </div>
        <button
            onclick="closeMemoForm()"
            class="ml-4 p-1.5 rounded-lg hover:bg-crimson-800 transition duration-150"
            title="Close"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- ── Scrollable Body ── -->
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6">

        <?php if ($memo_success): ?>
        <div class="p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-secondary">
            <?= htmlspecialchars($memo_success) ?>
        </div>
        <?php endif; ?>

        <?php if ($memo_error): ?>
        <div class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-secondary">
            <?= htmlspecialchars($memo_error) ?>
        </div>
        <?php endif; ?>

        <form id="memoForm" method="POST" action="" class="space-y-6">
            <input type="hidden" name="_memo_submit" value="1">

            <!-- ── Basic Info ── -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- MO# -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">
                        MO# <span class="text-crimson-600">*</span>
                    </label>
                    <input
                        type="text"
                        name="mo_number"
                        placeholder="e.g. MO-2024-001"
                        value="<?= htmlspecialchars($_POST['mo_number'] ?? '') ?>"
                        required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                    >
                </div>

                <!-- Date Issued -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">
                        Date Issued <span class="text-crimson-600">*</span>
                    </label>
                    <input
                        type="date"
                        name="date_issued"
                        value="<?= htmlspecialchars($_POST['date_issued'] ?? '') ?>"
                        required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm text-gray-500"
                    >
                </div>

            </div>

            <!-- Concerned Faculty -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">
                    Concerned Faculty <span class="text-crimson-600">*</span>
                </label>
                <input
                    type="text"
                    name="concerned_fac"
                    placeholder="Full name(s) of concerned faculty"
                    value="<?= htmlspecialchars($_POST['concerned_fac'] ?? '') ?>"
                    required
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                >
            </div>

            <!-- College + Department -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">College</label>
                    <input
                        type="text"
                        name="college"
                        placeholder="e.g. College of Engineering"
                        value="<?= htmlspecialchars($_POST['college'] ?? '') ?>"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">Department</label>
                    <input
                        type="text"
                        name="department"
                        placeholder="e.g. Dept. of Computer Science"
                        value="<?= htmlspecialchars($_POST['department'] ?? '') ?>"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                    >
                </div>

            </div>

            <!-- Subject -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">Subject</label>
                <textarea
                    name="subject"
                    rows="3"
                    placeholder="Describe the subject of this memorandum order..."
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm resize-none"
                ><?= htmlspecialchars($_POST['subject'] ?? '') ?></textarea>
            </div>

            <!-- ── Travel & Logistics ── -->
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 font-secondary">Travel &amp; Logistics</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">Destination</label>
                        <input
                            type="text"
                            name="destination"
                            placeholder="e.g. Cebu City, Cebu"
                            value="<?= htmlspecialchars($_POST['destination'] ?? '') ?>"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">Duration</label>
                        <input
                            type="text"
                            name="duration"
                            placeholder="e.g. January 4-7, 2025"
                            value="<?= htmlspecialchars($_POST['duration'] ?? '') ?>"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                        >
                    </div>

                </div>
            </div>

            <!-- ── Administrative Details ── -->
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 font-secondary">Administrative Details</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- R.F. (Request form)# -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">R.F. (Request form)#</label>
                        <input
                            type="text"
                            name="rf_number"
                            placeholder="e.g. RF-2024-045"
                            value="<?= htmlspecialchars($_POST['rf_number'] ?? '') ?>"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                        >
                    </div>

                    <!-- Source of Funds -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">Source of Funds</label>
                        <select
                            name="source_funds"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm text-gray-500"
                        >
                            <option value="">Select source...</option>
                            <option value="GAA"      <?= ($_POST['source_funds'] ?? '') === 'GAA'      ? 'selected' : '' ?>>GAA</option>
                            <option value="STF"      <?= ($_POST['source_funds'] ?? '') === 'STF'      ? 'selected' : '' ?>>STF</option>
                            <option value="IATF"     <?= ($_POST['source_funds'] ?? '') === 'IATF'     ? 'selected' : '' ?>>IATF</option>
                            <option value="IGP"      <?= ($_POST['source_funds'] ?? '') === 'IGP'      ? 'selected' : '' ?>>IGP</option>
                            <option value="External" <?= ($_POST['source_funds'] ?? '') === 'External' ? 'selected' : '' ?>>External</option>
                            <option value="Other"    <?= ($_POST['source_funds'] ?? '') === 'Other'    ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                </div>

                <!-- Number of Participants -->
                <div class="mt-4 sm:w-1/2 sm:pr-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 font-secondary">Number of Participant</label>
                    <input
                        type="number"
                        name="num_participant"
                        min="1"
                        placeholder="e.g. 12"
                        value="<?= htmlspecialchars($_POST['num_participant'] ?? '') ?>"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-crimson-700 focus:ring-2 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
                    >
                </div>
            </div>

        </form><!-- /memoForm -->

    </div><!-- /scrollable body -->

    <!-- ── Panel Footer (sticky action buttons) ── -->
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 shrink-0 flex flex-col sm:flex-row gap-3">
        <button
            type="button"
            onclick="closeMemoForm()"
            class="flex-1 bg-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-300 transition duration-200 font-secondary text-sm"
        >
            Cancel
        </button>
        <button
            type="button"
            onclick="saveMemoAsDraft()"
            class="flex-1 bg-white border-2 border-crimson-700 text-crimson-700 font-bold py-2.5 px-5 rounded-lg hover:bg-crimson-50 focus:outline-none focus:ring-4 focus:ring-crimson-200 transition duration-200 font-secondary text-sm"
        >
            Save as Draft
        </button>
        <button
            type="button"
            onclick="submitMemoForm()"
            class="flex-1 bg-crimson-700 text-white font-bold py-2.5 px-5 rounded-lg hover:bg-crimson-800 focus:outline-none focus:ring-4 focus:ring-crimson-300 transition duration-200 transform hover:scale-[1.02] active:scale-[0.98] font-secondary text-sm"
        >
            Done
        </button>
    </div>

</div><!-- /memoPanel -->


<!-- ═══════════════════════════════════════════════════════════════
     MEMO FORM JAVASCRIPT
     (openMemoForm / closeMemoForm are called from main.php)
═══════════════════════════════════════════════════════════════ -->
<script>
    function openMemoForm() {
        const overlay = document.getElementById('memoOverlay');
        const panel   = document.getElementById('memoPanel');

        overlay.classList.remove('hidden');
        // Trigger CSS transition
        requestAnimationFrame(() => {
            overlay.classList.add('opacity-100');
            overlay.classList.remove('opacity-0');
            panel.classList.remove('translate-x-full');
        });

        // Prevent body scroll while panel is open
        document.body.style.overflow = 'hidden';
    }

    function closeMemoForm() {
        const overlay = document.getElementById('memoOverlay');
        const panel   = document.getElementById('memoPanel');

        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        panel.classList.add('translate-x-full');

        // Wait for animation then hide
        setTimeout(() => {
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    function submitMemoForm() {
        const form = document.getElementById('memoForm');

        // Basic HTML5 validation
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Submit via standard POST (page will reload and re-open the panel if needed)
        // Or replace with fetch() for AJAX submission:
        form.submit();
    }

    function saveMemoAsDraft() {
        // TODO: hook up to your draft-saving logic
        alert('Memorandum Order saved as draft!');
        closeMemoForm();
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMemoForm();
    });
</script>