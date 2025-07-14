<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>Datamatrix</title>
</head>
<body>
@if(session('success'))
    <div role="alert" class="alert alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{session('success')}}</span>
    </div>
@endif
<div class="flex flex-col items-center justify-center mt-8">
    <x-card>
        <h2 class="text-2xl font-bold mb-4">Générateur de Datamatrix</h2>
        <label for="data" class="block text-sm font-medium text-gray-700 mb-2">Numéro de l'ordinateur</label>
        <form action="{{ route('data') }}" method="POST">
            @csrf
            <input id="data" name="data" class="w-full p-2 border border-gray-300 rounded-md" required></input>
            <button type="submit"
                    class=" mt-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Ajouter
            </button>

        </form>
    </x-card>
</div>
@if($datamatrix)
    <div class="flex flex-col items-center justify-center mt-8">
        <x-card>
            <div class="max-h-[50vh] overflow-y-auto">
                <h2 class=" text-center text-2xl font-bold mb-4">Liste des datamatrix</h2>
                <ul class="list">
                    @foreach($datamatrix as $data)
                        <x-table :key="$loop->index" :index="$loop->iteration" :value="$data"/>
                    @endforeach
                </ul>
            </div>
            
            <form action="{{ route('generatedata') }}" method="POST" class="flex flex-col items-center">
                @csrf
                <legend class="fieldset-legend">Combien de datamatrix par étiquette ? </legend>
                <select class="select select-sm w-1/4" id="quantity" name="quantity" required>
                    <option value="1">1</option>
                    <option selected value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>x§x§
                    <option value="5">5</option>
                </select>
                <button type="submit"
                        class=" rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold mt-2 text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Générer le PDF
                </button>
            </form>
        </x-card>
        
    </div>

@endif
</body>