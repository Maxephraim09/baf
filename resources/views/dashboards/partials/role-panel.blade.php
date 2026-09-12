@php
    $role = auth()->user()->getRoleNames()->first() ?: 'member';
@endphp
<style>
    .member-dashboard { background:linear-gradient(135deg,#f8fafc 0%,#eef2f7 100%); min-height:calc(100vh - 64px); padding:clamp(2rem,5vw,4.5rem) 1.25rem; }
    .member-shell { max-width:1180px; margin:0 auto; }
    .member-hero { align-items:flex-end; background:linear-gradient(135deg,var(--primary),var(--primary-dark)); border-radius:22px; box-shadow:0 18px 45px var(--primary-glow); color:#fff; display:flex; justify-content:space-between; gap:2rem; overflow:hidden; padding:clamp(1.5rem,4vw,3rem); position:relative; }
    .member-hero:after { background:rgba(255,255,255,.12); border-radius:50%; content:''; height:240px; position:absolute; right:-70px; top:-100px; width:240px; }
    .member-hero > * { position:relative; z-index:1; }
    .member-eyebrow { font-size:.73rem; font-weight:800; letter-spacing:.13em; opacity:.8; text-transform:uppercase; }
    .member-hero h1 { font-size:clamp(1.8rem,4vw,2.7rem); line-height:1.1; margin:.55rem 0 .7rem; }
    .member-hero p { color:rgba(255,255,255,.84); line-height:1.6; margin:0; max-width:610px; }
    .member-cta { align-items:center; background:#fff; border-radius:10px; color:var(--primary-dark); display:inline-flex; font-weight:800; gap:.55rem; padding:.8rem 1rem; text-decoration:none; white-space:nowrap; }
    .member-grid { display:grid; gap:1rem; grid-template-columns:repeat(3,minmax(0,1fr)); margin-top:1rem; }
    .member-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; box-shadow:0 10px 28px rgba(15,23,42,.06); padding:1.35rem; }
    .member-card-icon { align-items:center; background:var(--primary-glow); border-radius:11px; color:var(--primary); display:flex; height:40px; justify-content:center; width:40px; }
    .member-card-label { color:#64748b; font-size:.78rem; font-weight:700; margin-top:1rem; }
    .member-card-value { color:#172033; font-size:1.05rem; font-weight:800; margin-top:.35rem; overflow-wrap:anywhere; }
    .member-lower { display:grid; gap:1rem; grid-template-columns:1.3fr .7fr; margin-top:1rem; }
    .member-panel { background:#fff; border:1px solid #e2e8f0; border-radius:16px; box-shadow:0 10px 28px rgba(15,23,42,.06); padding:1.35rem; }
    .member-panel h2 { color:#172033; font-size:1.05rem; margin:0 0 .45rem; }
    .member-panel p { color:#64748b; line-height:1.6; margin:0; }
    .member-link { color:var(--primary-dark); font-weight:800; text-decoration:none; }
    .member-link:hover { color:var(--primary); text-decoration:underline; }
    @media (max-width:760px) { .member-hero { align-items:stretch; flex-direction:column; } .member-grid,.member-lower { grid-template-columns:1fr; } .member-cta { align-self:flex-start; } }
</style>
<div class="member-dashboard">
    <div class="member-shell">
        <section class="member-hero">
            <div><div class="member-eyebrow">{{ $roleLabel }}</div><h1>Welcome, {{ auth()->user()->name }}</h1><p>{{ $intro }}</p></div>
            <a class="member-cta" href="{{ $actionUrl }}"><i class="fas fa-arrow-right"></i> {{ $actionLabel }}</a>
        </section>
        <section class="member-grid" aria-label="Account summary">
            <article class="member-card"><div class="member-card-icon"><i class="fas fa-envelope"></i></div><div class="member-card-label">Account email</div><div class="member-card-value">{{ auth()->user()->email }}</div></article>
            <article class="member-card"><div class="member-card-icon"><i class="fas fa-shield-alt"></i></div><div class="member-card-label">Account type</div><div class="member-card-value">{{ ucfirst($role) }}</div></article>
            <article class="member-card"><div class="member-card-icon"><i class="fas fa-check-circle"></i></div><div class="member-card-label">Account status</div><div class="member-card-value">Active and ready</div></article>
        </section>
        <section class="member-lower">
            <article class="member-panel"><h2>{{ $panelTitle }}</h2><p>{{ $panelText }}</p></article>
            <article class="member-panel"><h2>Need assistance?</h2><p>Our team is ready to help with your account or next steps.</p><p style="margin-top:.8rem"><a class="member-link" href="{{ route('contact') }}">Contact the foundation <i class="fas fa-arrow-right"></i></a></p></article>
        </section>
    </div>
</div>
