<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">

                    <div>
                        <h1 class="text-2xl font-semibold">Dashboard</h1>
                        <p class="text-sm opacity-75">
                            Übersicht über deine wichtigsten Inhalte und Aktivitäten.
                        </p>
                    </div>

                    @if(auth()->user()->isVisitor())
                    <div>
                        <h3 class="text-lg font-semibold">Willkommen zurück, {{ auth()->user()->email }}</h3>
                        <p>
                            Hier findest du deine gemerkten Inhalte und später neue passende Jobanzeigen
                            zu Firmen und Kategorien, die dich interessieren.
                        </p>
                    </div>
                    @else
                    <div>
                        <h3 class="text-lg font-semibold">Willkommen, {{ auth()->user()->name }}</h3>
                        <p>
                            Hier findest du eine Übersicht über die für deine Rolle relevanten Informationen.
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            @if(auth()->user()->isVisitor())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Aktive Jobanzeigen</p>
                        <p class="text-3xl font-bold">{{ $activeJobsCount }}</p>
                        <p class="mt-2 text-sm opacity-75">
                            Diese aktuell sichtbaren Jobanzeigen kannst du durchsuchen und beobachten.
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Dein persönlicher Bereich</p>
                        <p class="text-base mt-2">
                            Sobald du Firmen oder Kategorien speicherst, findest du hier neue passende Jobs
                            und persönliche Übersichten.
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Aktive Jobs</p>
                        <p class="text-3xl font-bold">{{ $activeJobsCount }}</p>
                    </div>
                </div>

                @if(auth()->user()->isUser() || auth()->user()->isAdmin())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Meine Jobs</p>
                        <p class="text-3xl font-bold">{{ $myJobsCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Meine aktiven Jobs</p>
                        <p class="text-3xl font-bold">{{ $myActiveJobsCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Meine inaktiven Jobs</p>
                        <p class="text-3xl font-bold">{{ $myInactiveJobsCount }}</p>
                    </div>
                </div>
                @endif
            </div>
            @endif

            @if(auth()->user()->isVisitor())
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Gemerkte Firmen</h3>

                        @if($savedCompanies->isEmpty())
                        <p class="text-sm opacity-75">
                            Du hast noch keine Firmen gespeichert.
                        </p>
                        <p class="mt-2 text-sm opacity-75">
                            Sobald du später interessante Firmen markierst, erscheinen sie hier.
                        </p>
                        @else
                        <div class="space-y-3">
                            @foreach($savedCompanies as $company)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <p class="font-semibold">{{ $company->name }}</p>
                                <p class="text-sm opacity-75">
                                    Aktive Jobs: {{ $company->job_listings_count }}
                                </p>

                                <div class="mt-2 flex gap-2 flex-wrap">
                                    <a href="{{ route('jobs.index', ['company_id' => $company->id]) }}" class="btn btn-secondary">
                                        Jobs ansehen
                                    </a>

                                    <form action="{{ route('saved-companies.destroy', $company->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Entfernen</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Gemerkte Kategorien</h3>

                        @if($savedCategories->isEmpty())
                        <p class="text-sm opacity-75">
                            Du hast noch keine Kategorien gespeichert.
                        </p>
                        <p class="mt-2 text-sm opacity-75">
                            Später kannst du dir Kategorien merken und hier gesammelt wiederfinden.
                        </p>
                        @else
                        <div class="space-y-3">
                            @foreach($savedCategories as $category)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <p class="font-semibold">{{ $category->name }}</p>
                                <p class="text-sm opacity-75">
                                    Aktive Jobs: {{ $category->job_listings_count }}
                                </p>

                                <div class="mt-2 flex gap-2 flex-wrap">
                                    <a href="{{ route('jobs.index', ['category_id' => $category->id]) }}" class="btn btn-secondary">
                                        Jobs ansehen
                                    </a>

                                    <form action="{{ route('saved-categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Entfernen</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Neue passende Jobs</h3>

                        <div class="mb-4 flex flex-wrap items-center gap-3">
                            @if($referenceSeenAt)
                            <div>
                                <p class="text-sm opacity-75">
                                    Neue Jobs seit deinem letzten Besuch
                                </p>
                                <p class="text-sm opacity-75">
                                    {{ $referenceSeenAt->format('d.m.Y H:i') }}
                                </p>
                            </div>
                            @else
                            <p class="text-sm opacity-75">
                                Neue passende Jobs aus deinem aktuellen Interessensbereich.
                            </p>
                            @endif

                            <form action="{{ route('dashboard.refresh-matching-jobs') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Neue Jobs prüfen</button>
                            </form>

                            @if($newMatchingJobs->isNotEmpty())
                            <form action="{{ route('dashboard.mark-matching-jobs-as-seen') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Als gesehen markieren</button>
                            </form>
                            @endif
                        </div>

                        @if($newMatchingJobs->isEmpty())
                        <p class="text-sm opacity-75">
                            Aktuell gibt es noch keine neuen passenden Jobanzeigen für deine gemerkten Inhalte.
                        </p>
                        <p class="mt-2 text-sm opacity-75">
                            Sobald du Firmen oder Kategorien speicherst und neue passende Jobs erscheinen,
                            findest du sie hier.
                        </p>
                        @else
                        <div class="space-y-3">
                            @foreach($newMatchingJobs as $job)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <p class="font-semibold">{{ $job->title }}</p>

                                <p class="text-sm opacity-75">
                                    {{ optional($job->company)->name ?? 'Ohne Firma' }} ·
                                    {{ optional($job->category)->name ?? 'Ohne Kategorie' }}
                                </p>

                                <div class="mt-2">
                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-secondary">
                                        Ansehen
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user()->isUser() || auth()->user()->isAdmin())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Meine zuletzt bearbeiteten Jobs</h3>

                    @if($latestMyJobs->isEmpty())
                    <p>Du hast noch keine eigenen Jobanzeigen.</p>
                    @else
                    <div class="space-y-3">
                        @foreach($latestMyJobs as $job)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                            <p class="font-semibold">{{ $job->title }}</p>
                            <p class="text-sm opacity-75">
                                {{ optional($job->company)->name ?? 'Ohne Firma' }} ·
                                {{ optional($job->category)->name ?? 'Ohne Kategorie' }}
                            </p>
                            <p class="text-sm">
                                Status:
                                <span class="{{ $job->is_active ? 'text-green-600' : 'text-red-500' }}">
                                                {{ $job->is_active ? 'Aktiv' : 'Inaktiv' }}
                                            </span>
                            </p>
                            <div class="mt-2">
                                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary">Bearbeiten</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if(auth()->user()->isAdmin())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Alle Jobs</p>
                        <p class="text-3xl font-bold">{{ $allJobsCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Inaktive Jobs</p>
                        <p class="text-3xl font-bold">{{ $inactiveJobsCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Firmen</p>
                        <p class="text-3xl font-bold">{{ $companiesCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Kategorien</p>
                        <p class="text-3xl font-bold">{{ $categoriesCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Benutzer gesamt</p>
                        <p class="text-3xl font-bold">{{ $usersCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Admins</p>
                        <p class="text-3xl font-bold">{{ $adminsCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Interne User</p>
                        <p class="text-3xl font-bold">{{ $internalUsersCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm opacity-75">Visitor</p>
                        <p class="text-3xl font-bold">{{ $visitorsCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Schnellzugriffe</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('jobs.create') }}" class="btn btn-primary">Job erstellen</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Benutzerverwaltung</a>
                        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Firmen</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kategorien</a>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
