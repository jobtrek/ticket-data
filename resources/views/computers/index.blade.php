<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>Ordinateurs</title>
</head>
<body>
<div class="px-4 sm:px-6 lg:px-8 ">
    <div class="mt-8 flow-root">
        <form>
        <x-page-header/>
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <div class="flex gap-3">
                            <input type="checkbox" id="checkAll">
                            <a href="#" class="group inline-flex">
                                Nom
                                <span class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                         data-slot="icon">
                                        <path fill-rule="evenodd"
                                              d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </a>
                            </div>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <a href="#" class="group inline-flex">
                                Fabricant
                                <!-- Active: "bg-gray-200 text-gray-900 group-hover:bg-gray-300", Not Active: "invisible text-gray-400 group-hover:visible group-focus:visible" -->
                                <span class="ml-2 flex-none rounded bg-gray-100 text-gray-900 group-hover:bg-gray-200">
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                         data-slot="icon">
                                        <path fill-rule="evenodd"
                                              d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <a href="#" class="group inline-flex">
                                Numéro de série
                                <!-- Active: "bg-gray-200 text-gray-900 group-hover:bg-gray-300", Not Active: "invisible text-gray-400 group-hover:visible group-focus:visible" -->
                                <span class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
                                    <svg class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                              d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <a href="#" class="group inline-flex">
                                Modèle
                                <!-- Active: "bg-gray-200 text-gray-900 group-hover:bg-gray-300", Not Active: "invisible text-gray-400 group-hover:visible group-focus:visible" -->
                                <span class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
                                    <svg class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                              d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <a href="#" class="group inline-flex">
                                UUID
                                <!-- Active: "bg-gray-200 text-gray-900 group-hover:bg-gray-300", Not Active: "invisible text-gray-400 group-hover:visible group-focus:visible" -->
                                <span class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
                                    <svg class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                              d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </a>
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-0">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($computers as $computer)
                        <tr>
                            <td>
                                <div class="flex gap-3">
                                    <input type="checkbox" name="" class="checkItem" value={{$computer['id']}}>
                                    <a class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{$computer['name']}}</a>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$computer['manufacturers_id']}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$computer['serial']}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$computer['computermodels_id']}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$computer['uuid']}}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm sm:pr-0">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </form>
    </div>
</div>
<x-paginate :items="$computers"></x-paginate>
</body>
</html>