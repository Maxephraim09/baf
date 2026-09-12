@extends('layouts.admin')

@section('content')
@php
    $progress = $totalGoal > 0 ? min(($stats['raised'] / $totalGoal) * 100, 100) : 0;
    $money = fn ($value) => number_format((float) $value, 2);
@endphp
<style>
    .admin-dashboard { max-width: 1480px; margin: 0 auto; }
    .dashboard-intro { display:flex; align-items:flex-end; justify-content:space-between; gap:2rem; margin-bottom:2rem; }
    .dashboard-kicker { color:var(--primary); font-size:.75rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
    .dashboard-intro h1 { color:var(--text-strong); font-size:clamp(1.8rem, 3vw, 2.5rem); line-height:1.1; margin:.45rem 0 .7rem; }
    .dashboard-intro p { color:var(--gray-500); max-width:620px; margin:0; line-height:1.6; }
    .dashboard-actions { display:flex; flex-wrap:wrap; gap:.75rem; }
    .dashboard-actions a { white-space:nowrap; }
    .metrics-grid { display:grid; grid-template-columns:repeat(4, minmax(0,1fr)); gap:1rem; margin-bottom:1rem; }
    .metric-card, .dashboard-panel { background:var(--surface); border:1px solid var(--gray-200); border-radius:16px; box-shadow:0 10px 30px rgba(15,23,42,.06); color:var(--text-body); }
    .metric-card { padding:1.25rem; min-height:145px; position:relative; overflow:hidden; }
    .metric-card:after { content:''; width:100px; height:100px; border-radius:50%; background:var(--primary-glow); position:absolute; right:-38px; top:-38px; }
    .metric-top { display:flex; justify-content:space-between; gap:1rem; align-items:center; position:relative; z-index:1; }
    .metric-icon { width:40px; height:40px; border-radius:11px; display:grid; place-items:center; background:var(--primary-glow); color:var(--primary); }
    .metric-label { color:var(--text-muted); font-size:.82rem; font-weight:700; }
    .metric-value { color:var(--text-strong); font-size:1.65rem; font-weight:800; margin-top:1rem; }
    .metric-note { color:var(--text-muted); font-size:.78rem; margin-top:.25rem; }
    .dashboard-columns { display:grid; grid-template-columns:minmax(0,1.35fr) minmax(320px,.65fr); gap:1rem; }
    .dashboard-panel { padding:1.35rem; }
    .panel-heading { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.2rem; }
    .panel-heading h2 { color:var(--text-strong); font-size:1.05rem; margin:0; }
    .panel-heading p { color:var(--text-muted); font-size:.82rem; margin:.3rem 0 0; }
    .panel-link { color:var(--primary); font-size:.82rem; font-weight:800; text-decoration:none; white-space:nowrap; }
    .dashboard-table { border-collapse:collapse; width:100%; }
    .dashboard-table th { color:var(--text-muted); font-size:.7rem; letter-spacing:.08em; padding:.7rem .5rem; text-align:left; text-transform:uppercase; }
    .dashboard-table td { border-top:1px solid var(--gray-200); color:var(--text-body); font-size:.86rem; padding:.85rem .5rem; vertical-align:middle; }
    .dashboard-table strong { color:var(--text-strong); }
    .dashboard-table small { color:var(--text-muted); }
    .status-pill { border-radius:999px; display:inline-flex; font-size:.7rem; font-weight:800; padding:.35rem .6rem; text-transform:capitalize; }
    .status-pill.completed, .status-pill.successful, .status-pill.confirmed, .status-pill.paid { background:#dcfce7; color:#166534; }
    .status-pill.pending { background:#fef3c7; color:#92400e; }
    .status-pill.failed, .status-pill.refunded, .status-pill.cancelled { background:#fee2e2; color:#991b1b; }
    .progress-summary { background:linear-gradient(145deg, var(--secondary), var(--secondary-light)); border:0; color:#fff; }
    .progress-summary h2, .progress-summary p, .progress-summary .panel-heading p { color:#fff; }
    .progress-summary .panel-heading p { opacity:.7; }
    .progress-number { font-size:2.4rem; font-weight:800; margin:1.4rem 0 .35rem; }
    .progress-track { background:rgba(255,255,255,.18); border-radius:999px; height:9px; overflow:hidden; }
    .progress-track span { background:var(--accent); border-radius:inherit; display:block; height:100%; }
    .progress-meta { display:flex; justify-content:space-between; color:rgba(255,255,255,.72); font-size:.78rem; margin-top:.65rem; }
    .quick-actions { display:grid; gap:.65rem; margin-top:1.25rem; }
    .quick-action { align-items:center; border:1px solid var(--gray-200); border-radius:10px; color:var(--text-body); display:flex; gap:.75rem; padding:.8rem; text-decoration:none; transition:.2s ease; }
    .quick-action:hover { border-color:var(--primary); color:var(--primary); transform:translateX(2px); }
    .quick-action i { color:var(--primary); width:18px; }
    @media (max-width:1100px) { .metrics-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } .dashboard-columns { grid-template-columns:1fr; } }
    @media (max-width:620px) { .dashboard-intro { align-items:stretch; flex-direction:column; } .metrics-grid { grid-template-columns:1fr; } .dashboard-panel { overflow-x:auto; } .dashboard-table { min-width:560px; } }
</style>

<div class="admin-dashboard">
    <header class="dashboard-intro">
        <div><div class="dashboard-kicker">Operations overview</div><h1>Good morning, {{ auth()->user()->name }}</h1><p>Track the foundation's live work, incoming support, and the actions that need your attention today.</p></div>
        <div class="dashboard-actions"><a class="btn-secondary" href="{{ route('admin.settings') }}"><i class="fas fa-sliders-h"></i> Settings</a><a class="btn-primary" href="{{ route('admin.cms.index') }}"><i class="fas fa-edit"></i> Manage CMS</a></div>
    </header>

    <section class="metrics-grid" aria-label="Key metrics">
        <article class="metric-card"><div class="metric-top"><span class="metric-label">Live projects</span><span class="metric-icon"><i class="fas fa-project-diagram"></i></span></div><div class="metric-value">{{ $stats['projects'] }}</div><div class="metric-note">Currently visible on the website</div></article>
        <article class="metric-card"><div class="metric-top"><span class="metric-label">Confirmed raised</span><span class="metric-icon"><i class="fas fa-hand-holding-usd"></i></span></div><div class="metric-value">{{ $money($stats['raised']) }}</div><div class="metric-note">Successful donations only</div></article>
        <article class="metric-card"><div class="metric-top"><span class="metric-label">Upcoming events</span><span class="metric-icon"><i class="fas fa-calendar-alt"></i></span></div><div class="metric-value">{{ $stats['events'] }}</div><div class="metric-note">Active future events</div></article>
        <article class="metric-card"><div class="metric-top"><span class="metric-label">Active volunteers</span><span class="metric-icon"><i class="fas fa-users"></i></span></div><div class="metric-value">{{ $stats['volunteers'] }}</div><div class="metric-note">Reviewed or accepted profiles</div></article>
    </section>

    <div class="dashboard-columns">
        <section class="dashboard-panel"><div class="panel-heading"><div><h2>Recent donations</h2><p>Latest payment activity across the foundation.</p></div><a class="panel-link" href="{{ route('admin.dashboard') }}">View activity <i class="fas fa-arrow-right"></i></a></div><div style="overflow-x:auto"><table class="dashboard-table"><thead><tr><th>Donor</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody>@forelse($recentDonations as $donation)<tr><td><strong>{{ $donation->is_anonymous ? 'Anonymous donor' : $donation->donor_name }}</strong><br><small>{{ $donation->donor_email }}</small></td><td><strong>{{ $money($donation->amount) }}</strong></td><td><span class="status-pill {{ $donation->status }}">{{ $donation->status }}</span></td><td>{{ $donation->created_at->format('M j, Y') }}</td></tr>@empty<tr><td colspan="4">No donations recorded yet.</td></tr>@endforelse</tbody></table></div></section>
        <aside class="dashboard-panel progress-summary"><div class="panel-heading"><div><h2>Funding progress</h2><p>Across active projects</p></div><i class="fas fa-chart-line"></i></div><div class="progress-number">{{ number_format($progress, 1) }}%</div><div class="progress-track"><span style="width:{{ $progress }}%"></span></div><div class="progress-meta"><span>Raised {{ $money($stats['raised']) }}</span><span>Goal {{ $money($totalGoal) }}</span></div><div class="quick-actions"><a class="quick-action" href="{{ route('admin.cms.index', ['tab' => 'projects']) }}"><i class="fas fa-project-diagram"></i> Review projects <i class="fas fa-arrow-right" style="margin-left:auto"></i></a><a class="quick-action" href="{{ route('admin.cms.index', ['tab' => 'events']) }}"><i class="fas fa-calendar"></i> Manage events <i class="fas fa-arrow-right" style="margin-left:auto"></i></a></div></aside>
    </div>

    <section class="dashboard-panel" style="margin-top:1rem"><div class="panel-heading"><div><h2>Project pulse</h2><p>Quick view of the campaigns currently shown to visitors.</p></div><a class="panel-link" href="{{ route('admin.cms.index', ['tab' => 'projects']) }}">Manage projects <i class="fas fa-arrow-right"></i></a></div><div style="display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">@forelse($projects as $project) @php($projectRaised = min((float)($project->raised_total ?? 0), (float)$project->goal_amount)) @php($projectProgress = $project->goal_amount > 0 ? min(($projectRaised / $project->goal_amount) * 100, 100) : 0)<div><div style="display:flex;justify-content:space-between;gap:.5rem;font-size:.82rem"><strong>{{ $project->title }}</strong><span>{{ number_format($projectProgress, 0) }}%</span></div><div class="progress-track" style="background:var(--gray-200);margin-top:.5rem"><span style="background:var(--primary);width:{{ $projectProgress }}%"></span></div></div>@empty<p>No active projects yet.</p>@endforelse</div></section>
+</div>
+@endsection
