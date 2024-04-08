<div class="appBottomMenu mt-5">
    <a href="{{ route('employee.dashboard') }}" class="item {{ 'employee' == request()->path() ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="alarm-outline" role="img" class="md hydrated"
                aria-label="alarm outline"></ion-icon>
            <strong>Presensi</strong>
        </div>
    </a>
    <a href="{{ route('employee.agenda') }}" class="item {{ 'employee/agenda' == request()->path() ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                aria-label="calendar outline"></ion-icon>
            <strong>Agenda</strong>
        </div>
    </a>
    <a href="{{ route('employee.perijinan') }}" class="item {{ 'employee/perijinan' == request()->path() ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>Perizinan</strong>
        </div>
    </a>
    <a href="{{ route('employee.profil') }}" class="item {{ Str::startsWith(request()->path(), 'employee/profil') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profil</strong>
        </div>
    </a>
</div>
