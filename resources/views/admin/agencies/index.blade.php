@extends('admin.Layout.app')

@section('content')
<table>
    <thead>
        <tr>
            <th>Project</th>
            <th>Status</th>
            <th>Progress</th>
            <th>Due Date</th>
            <th>Team</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Website Redesign</td>
            <td><span class="status-badge active">Active</span></td>
            <td>
                <div class="progress-bar"><div style="width: 75%"></div></div>
            </td>
            <td>2024-03-15</td>
            <td>
                <div class="team-members">
                    <img src="profile.jpg" alt="Member">
                    <img src="profile.jpg" alt="Member">
                    <img src="profile.jpg" alt="Member">
                </div>
            </td>
        </tr>
        </tbody>
</table>
@endsection

