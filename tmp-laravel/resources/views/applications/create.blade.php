<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Přihláška na stáž
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                @if ($existing)
                    <p class="mb-4">Už máš přihlášku (stav: {{ $existing->status }}), destinace: {{ $existing->mobility->destination }}.</p>
                @endif

                <form method="POST" action="{{ route('applications.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="mobility_id" value="Mobilita" />
                        <select id="mobility_id" name="mobility_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($mobilities as $mobility)
                                <option value="{{ $mobility->id }}">{{ $mobility->destination }} ({{ $mobility->type }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('mobility_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="class_teacher_id" value="Třídní učitel" />
                        <select id="class_teacher_id" name="class_teacher_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->last_name }} {{ $teacher->first_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('class_teacher_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="english_teacher_id" value="Učitel AJ" />
                        <select id="english_teacher_id" name="english_teacher_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->last_name }} {{ $teacher->first_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('english_teacher_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="preferred_type" value="Preference stáže" />
                        <select id="preferred_type" name="preferred_type" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="kratkodoba">Krátkodobá</option>
                            <option value="dlouhodoba">Dlouhodobá</option>
                        </select>
                    </div>

                    <div class="block mt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="gdpr_consent" value="1" class="rounded border-gray-300" required>
                            <span class="ms-2 text-sm">Souhlasím se zpracováním osobních údajů (GDPR).</span>
                        </label>
                        <x-input-error :messages="$errors->get('gdpr_consent')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>Odeslat přihlášku</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>