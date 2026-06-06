@extends('layouts.admin')

@section('content')
<div class="dashboard-page">
    <div class="dashboard-hero">
        <div>
            <h1>Welcome back, Superadmin</h1>
            <p>Monitor your campaigns, donations, events and site performance from one place.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.settings') }}" class="btn-secondary">System Settings</a>
            <a href="{{ route('admin.dashboard') }}" class="btn-primary">Refresh Metrics</a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-project-diagram"></i></div>
            <div class="stat-number">8</div>
            <div class="stat-label">Live Projects</div>
            <div class="stat-trend"><i class="fas fa-arrow-up"></i> 2 new this month</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-number">$128,450</div>
            <div class="stat-label">Funds Raised</div>
            <div class="stat-trend"><i class="fas fa-arrow-up"></i> 18% increase</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-number">6</div>
            <div class="stat-label">Upcoming Events</div>
            <div class="stat-trend"><i class="fas fa-calendar-check"></i> 3 scheduled</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-hands-helping"></i></div>
            <div class="stat-number">1,250</div>
            <div class="stat-label">Active Volunteers</div>
            <div class="stat-trend"><i class="fas fa-user-plus"></i> 75 new</div>
        </div>
    </div>

    <div class="dashboard-panels">
        <section class="data-table panel-card">
            <div class="table-header">
                <h3>Recent Donations</h3>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">View All Donations</a>
            </div>
            <table class="table recent-table" width="100%">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>John Doe</strong><br><small>john@example.com</small></td>
                        <td><strong>$500</strong></td>
                        <td><span class="status-badge status-completed">Completed</span></td>
                        <td>2026-06-02</td>
                    </tr>
                    <tr>
                        <td><strong>Jane Smith</strong><br><small>jane@example.com</small></td>
                        <td><strong>$1,000</strong></td>
                        <td><span class="status-badge status-completed">Completed</span></td>
                        <td>2026-06-01</td>
                    </tr>
                    <tr>
                        <td><strong>Mike Johnson</strong><br><small>mike@example.com</small></td>
                        <td><strong>$250</strong></td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>2026-05-30</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="panel-card summary-card">
            <div class="summary-header">
                <div>
                    <h3>Project Snapshot</h3>
                    <p>See how your active campaigns are performing.</p>
                </div>
                <span class="status-badge status-active">Healthy</span>
            </div>

            <div class="summary-grid">
                <div class="summary-item">
                    <span>Goal</span>
                    <strong>$625,000</strong>
                </div>
                <div class="summary-item">
                    <span>Raised</span>
                    <strong>$282,450</strong>
                </div>
                <div class="summary-item">
                    <span>Completed</span>
                    <strong>4</strong>
                </div>
                <div class="summary-item">
                    <span>In Progress</span>
                    <strong>4</strong>
                </div>
            </div>

            <div class="progress-stack">
                <div>
                    <span>Clean Water Initiative</span>
                    <div class="progress-bar"><div style="width: 72%;"></div></div>
                </div>
                <div>
                    <span>School Building Project</span>
                    <div class="progress-bar"><div style="width: 52%;"></div></div>
                </div>
                <div>
                    <span>Medical Camps</span>
                    <div class="progress-bar"><div style="width: 40%;"></div></div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
