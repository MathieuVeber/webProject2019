@guest
  @include('layouts.navbarGuest')
@endguest

@auth
  @includeWhen($user->admin, 'layouts.navbarAdmin')
  @includeWhen(!$user->admin, 'layouts.navbarUser')
@endauth
