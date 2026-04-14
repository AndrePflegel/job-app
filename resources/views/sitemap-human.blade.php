<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 space-y-8">

                    <div>
                        <h1 class="text-2xl font-semibold">Sitemap / Seitenstruktur</h1>
                        <p class="mt-2 text-sm opacity-75">
                            Übersicht über die wichtigsten Bereiche der Anwendung und ihre Beziehungen.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold mb-4">Öffentlicher Bereich</h2>

                            <div class="space-y-4">
                                <div>
                                    <a href="{{ route('jobs.index') }}" class="font-semibold underline underline-offset-2">
                                        Startseite / Jobübersicht
                                    </a>

                                    <div class="mt-3 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-3">
                                        <div>
                                            <p class="font-medium">Filter</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 text-sm opacity-90">
                                                <p>nach Firma</p>
                                                <p>nach Kategorie</p>
                                            </div>
                                        </div>

                                        <div>
                                            <p class="font-medium">Jobdetailseiten</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 text-sm">
                                                <p>Einzelne Jobanzeige</p>
                                                <p class="opacity-75">/jobs/{id}</p>
                                            </div>
                                        </div>

                                        <div>
                                            <p class="font-medium">Authentifizierung</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 text-sm">
                                                <a href="{{ route('login') }}" class="underline underline-offset-2">Login</a>
                                                @if (Route::has('register'))
                                                <a href="{{ route('register') }}" class="block underline underline-offset-2">Registrierung</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @auth
                        <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold mb-4">Bereich für eingeloggte Nutzer</h2>

                            <div class="space-y-4">
                                <div>
                                    <a href="{{ route('dashboard') }}" class="font-semibold underline underline-offset-2">
                                        Dashboard
                                    </a>

                                    <div class="mt-3 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-3 text-sm">
                                        @cannot('create', App\Models\JobListing::class)
                                        <div>
                                            <p class="font-medium">Visitor</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 opacity-90">
                                                <p>Gemerkte Firmen</p>
                                                <p>Gemerkte Kategorien</p>
                                                <p>Neue passende Jobs</p>
                                            </div>
                                        </div>
                                        @endcannot

                                        @can('create', App\Models\JobListing::class)
                                        <div>
                                            <p class="font-medium">User / Admin</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 opacity-90">
                                                <p>Eigene Kennzahlen</p>
                                                <p>Zuletzt bearbeitete Jobs</p>
                                            </div>
                                        </div>
                                        @endcan
                                    </div>
                                </div>

                                @can('create', App\Models\JobListing::class)
                                <div>
                                    <a href="{{ route('jobs.my') }}" class="font-semibold underline underline-offset-2">
                                        Meine Jobs
                                    </a>
                                </div>
                                @endcan

                                <div>
                                    <a href="{{ route('profile.edit') }}" class="font-semibold underline underline-offset-2">
                                        Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endauth

                        @can('viewAny', App\Models\User::class)
                        <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold mb-4">Admin-Bereich</h2>

                            <div class="space-y-4">
                                <div>
                                    <p class="font-semibold">Verwaltung</p>

                                    <div class="mt-3 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-3 text-sm">
                                        @can('viewAny', App\Models\Company::class)
                                        <div>
                                            <p class="font-medium">Firmen</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 opacity-90">
                                                <p>Liste</p>
                                                <p>Erstellen</p>
                                                <p>Bearbeiten</p>
                                                <p>Löschen</p>
                                            </div>
                                        </div>
                                        @endcan

                                        @can('viewAny', App\Models\Category::class)
                                        <div>
                                            <p class="font-medium">Kategorien</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 opacity-90">
                                                <p>Liste</p>
                                                <p>Erstellen</p>
                                                <p>Bearbeiten</p>
                                                <p>Löschen</p>
                                            </div>
                                        </div>
                                        @endcan

                                        @can('viewAny', App\Models\User::class)
                                        <div>
                                            <p class="font-medium">Benutzer</p>
                                            <div class="mt-1 ml-4 pl-4 border-l border-gray-300 dark:border-gray-600 space-y-1 opacity-90">
                                                <p>Liste</p>
                                                <p>Erstellen</p>
                                                <p>Bearbeiten</p>
                                                <p>Löschen</p>
                                            </div>
                                        </div>
                                        @endcan
                                    </div>
                                </div>

                                <div class="text-sm opacity-75">
                                    Nur für Administratoren sichtbar.
                                </div>
                            </div>
                        </div>
                        @endcan

                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold mb-3">Technische Sitemap</h2>
                        <p class="text-sm opacity-90">
                            Für Suchmaschinen gibt es zusätzlich die XML-Sitemap unter
                            <a href="{{ url('/sitemap.xml') }}" class="underline underline-offset-2">
                                {{ url('/sitemap.xml') }}
                            </a>.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
