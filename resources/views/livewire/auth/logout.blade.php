<div class="w-full" x-data>
    @if($isResponsive)
        <form>
            <x-dropdown-link href="{{ route('logout') }}"
                             wire:click.prevent="logout">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    @else
        <form>
            <x-responsive-nav-link href="{{ route('logout') }}"
                                   wire:click.prevent="logout">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
    @endif

</div>
