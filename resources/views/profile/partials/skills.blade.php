<div class="skills-manager">
    <h6>Skills</h6>

    {{-- Form posts to profile.update and sends skills_input as comma-separated list --}}
    <form id="skillsForm" action="{{ route('profile.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-2" id="skillsContainer">
            {{-- existing skills as chips --}}
            @php $skillsList = $user->skills ?? []; @endphp
            @foreach($skillsList as $skill)
                <span class="badge bg-info text-dark me-1 mb-1 skill-chip">
                    <span class="skill-text">{{ $skill }}</span>
                    <button type="button" class="btn-close btn-close-white btn-remove-skill ms-2" aria-label="Remove" title="Remove"></button>
                </span>
            @endforeach
        </div>

        <div class="input-group mb-2">
            <input id="skillInput" type="text" class="form-control" placeholder="Add a skill and press Enter" aria-label="Add skill">
            <button id="addSkillBtn" class="btn btn-outline-secondary" type="button">Add</button>
        </div>

        <input type="hidden" name="skills_input" id="skillsInputHidden" value="{{ !empty($skillsList) ? implode(', ', $skillsList) : '' }}">

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Save Skills</button>
        </div>
    </form>
</div>

{{-- Skills manager JS (minimal, unobtrusive) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const skillsContainer = document.getElementById('skillsContainer');
    const skillInput = document.getElementById('skillInput');
    const addSkillBtn = document.getElementById('addSkillBtn');
    const skillsHidden = document.getElementById('skillsInputHidden');
    const skillsForm = document.getElementById('skillsForm');

    function getSkillsArray() {
        const chips = skillsContainer.querySelectorAll('.skill-text');
        return Array.from(chips).map(el => el.textContent.trim()).filter(Boolean);
    }

    function refreshHidden() {
        skillsHidden.value = getSkillsArray().join(', ');
    }

    function createChip(text) {
        const span = document.createElement('span');
        span.className = 'badge bg-info text-dark me-1 mb-1 skill-chip';
        span.innerHTML = `<span class="skill-text"></span>`;
        span.querySelector('.skill-text').textContent = text;
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn-close btn-close-white btn-remove-skill ms-2';
        btn.setAttribute('aria-label','Remove');
        btn.addEventListener('click', () => { span.remove(); refreshHidden(); });
        span.appendChild(btn);
        return span;
    }

    addSkillBtn.addEventListener('click', () => {
        const value = skillInput.value.trim();
        if (!value) return;
        // avoid duplicates
        const existing = getSkillsArray().map(s => s.toLowerCase());
        if (existing.includes(value.toLowerCase())) {
            skillInput.value = '';
            return;
        }
        skillsContainer.appendChild(createChip(value));
        skillInput.value = '';
        refreshHidden();
    });

    skillInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkillBtn.click();
        }
    });

    // delegate remove clicks for pre-rendered chips
    skillsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-skill')) {
            e.target.closest('.skill-chip').remove();
            refreshHidden();
        }
    });

    // Ensure hidden input sync before submit (in case user used browser autofill)
    skillsForm.addEventListener('submit', function () {
        refreshHidden();
    });
});
</script>

<style>
.skill-chip { display:inline-flex; align-items:center; padding: 6px 8px; font-size: .9rem; }
.btn-remove-skill { width: 20px; height: 20px; opacity: .9; }
</style>
