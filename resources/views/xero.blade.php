<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Xero') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($error)
                        <h1>Your connection to Xero failed</h1>
                        <p>{{ $error }}</p>
                        <a href="{{ route('xero.auth.authorize') }}" class="btn btn-primary btn-large mt-4 inline-block">
                            Reconnect to Xero
                        </a>
                    @elseif($connected)
                        <h1>You are connected to Xero</h1>
                        <p>{{ $organisationName }} via {{ $username }}</p>
                        <a href="{{ route('xero.auth.authorize') }}" class="btn btn-primary btn-large mt-4 inline-block">
                            Reconnect to Xero
                        </a>
                    @else
                        <h1>You are not connected to Xero</h1>
                        <a href="{{ route('xero.auth.authorize') }}" class="btn btn-primary btn-large mt-4 inline-block">
                            Connect to Xero
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
