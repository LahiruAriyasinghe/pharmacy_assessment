@guest
@else
<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>
            <a href="{{ route('home') }}"><img style="height: 55px;" src="{{ asset('img/logo-long.svg') }}"></a>
        </h3>
        <strong>
            <a href="{{ route('home') }}"><img style="width: 40px;" src="{{ asset('img/favicon.svg') }}"></a>
        </strong>
    </div>
    <hr>

    <ul id="nav" class="list-unstyled">
        <li class="">
            <a href="{{ route('home') }}">
                <img class="sidebar-tile-icon" src="{{ asset('img/architecture-and-city.svg') }}">
                <span>Dashboard</span>
            </a>
        </li>
        
        @can('view user', App\User::class)
        <li class="">
            <a href="#manageUsers" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <img class="sidebar-tile-icon" src="{{ asset('img/group.svg') }}">
                <span>Manage Users</span>
            </a>
            <ul class="collapse list-unstyled" id="manageUsers">
                <li>
                    <a href="{{route('users.index')}}">Users</a>
                </li>
                @can('view role', App\User::class)
                <li>
                    <a href="{{route('roles.index')}}">Roles</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        @can('view doctor', App\User::class)
        <li class="">
            <a href="{{route('specialties.index')}}">
                <img class="sidebar-tile-icon" src="{{ asset('img/specialist.svg') }}">
                <span>Specialities</span>
            </a>
        </li>
        @endcan

        @can('view service', App\User::class)
        <li class="">
            <a href="{{route('other-services.index')}}">
                <img class="sidebar-tile-icon" src="{{ asset('img/veterinary.svg') }}">
                <span>Other Services</span>
            </a>
        </li>
        @endcan

        @can('create invoice', App\User::class)
        <li class="">
            <a href="{{route('reports.cashier.index')}}">
                <img class="sidebar-tile-icon" src="{{ asset('img/finance-report.svg') }}">
                <span>Cashier Reports</span>
            </a>
        </li>
        @endcan

        @can('view all cash reports', App\User::class)
        <li class="">
            <a href="{{route('reports.admin.index')}}">
                <img class="sidebar-tile-icon" src="{{ asset('img/admin-report.svg') }}">
                <span>Reports Admin</span>
            </a>
        </li>
        @endcan

        @can('view product', App\User::class)
        <li class="">
            <a href="{{route('products.index')}}">
                <img class="sidebar-tile-icon" src="{{ asset('img/pharmacy.svg') }}">
                <span>Pharmacy</span>
            </a>
        </li>
        @endcan

        @can('update patient lab report', App\User::class)
        <li class="">
            <a href="{{route('managelabreports')}}">
                <img class="sidebar-tile-icon" src="{{ asset('img/result.svg') }}">
                <span>Manage Lab Reports</span>
            </a>
        </li>
        @endcan
    </ul>
    <hr class="pb-5">
</nav>
@endguest


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>

<script type="text/javascript">
$(function(){
    var current = location.pathname;
    $('#nav li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.parent().addClass('active');
        }
    })
})

$(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });
});

$(document).on('click', '#sidebar .list-unstyled li', function() {
    $(this).addClass('active').siblings().removeClass('active')
})

</script>