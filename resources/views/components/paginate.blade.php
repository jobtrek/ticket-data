<div class=" flex border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            {{--<form method="GET">
                <select class="relative inline-flex px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300 ring-inset focus:outline-offset-0" name="perPage" onchange="this.form.submit()">
                    @for ($i = 10 ; $i + 10 < $paginator->total() ; $i+=15)
                        <option value={{ $i }} {{ $paginator->perPage()  ==  $i ? 'selected' : ''}} >{{ $i }}</option>
                    @endfor
                        <option value={{$paginator->total()}} {{ $paginator->perPage()  ==  $paginator->total() ? 'selected' : ''}} >Tous</option>
                </select>
            </form>--}}
        {{-- Responsive --}}
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center rounded-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset focus:z-20 focus:outline-offset-0">
                    <p>Précedent</p>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl()}}"
                   class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Précedent
                </a>
            @endif
                @if ($paginator->onLastPage())
                    <span class="relative inline-flex items-center rounded-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset focus:z-20 focus:outline-offset-0">
                    <p>Suivant</p>
                </span>
                @else
                    <a href="{{ $paginator->nextPageUrl()}}"
                       class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Suivant
                    </a>
                @endif
        </div>
        <div class=" hidden sm:flex sm:flex-1 sm:items-center sm:justify-between flex-col">
            <div class="mb-2">
                <p class="text-sm text-gray-700">
                    De
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        à
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    sûr
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    résultats
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
                    @if (!$paginator->onFirstPage())
                        <a href="{{ $paginator->url(1)}}"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L6.31 10l3.72-3.72a.75.75 0 1 0-1.06-1.06L4.72 9.47Zm9.25-4.25L9.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L11.31 10l3.72-3.72a.75.75 0 0 0-1.06-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L6.31 10l3.72-3.72a.75.75 0 1 0-1.06-1.06L4.72 9.47Zm9.25-4.25L9.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L11.31 10l3.72-3.72a.75.75 0 0 0-1.06-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                 data-slot="icon">
                                <path fill-rule="evenodd"
                                      d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                           class="relative inline-flex items-center px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                 data-slot="icon">
                                <path fill-rule="evenodd"
                                      d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @endif
                    @foreach($elements as $element)
                        @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300 ring-inset focus:outline-offset-0">{{$element}}</span>
                                </span>
                        @endif
                        @if(is_array($element))
                            @if($paginator->currentPage() -1 !== 1 && $paginator->currentPage() !== 1 )
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300 ring-inset focus:outline-offset-0">...</span>
                                @endif
                            @foreach($element as $page => $url)
                                @if ($page === $paginator->currentPage())
                                        <span aria-disabled="true">
                                            <span class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{$page}}</span>
                                        </span>
                                    @elseif($page === $paginator->currentPage() + 1  || $page === $paginator->currentPage() -1 )
                                        <a href="{{$url}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300 ring-inset focus:outline-offset-0" >{{$page}}</a>
                                @endif
                            @endforeach
                                @if($paginator->currentPage() +1 !== $paginator->lastPage() && $paginator->currentPage() !== $paginator->lastPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300 ring-inset focus:outline-offset-0">...</span>
                                @endif
                        @endif
                    @endforeach
                        @if($paginator->hasMorePages())
                            <a href="{{$paginator->nextPageUrl()}}"
                               class="relative inline-flex items-center px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd"
                                          d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @else
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                         data-slot="icon">
                                        <path fill-rule="evenodd"
                                              d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </span>
                        @endif
                        @if(!$paginator->onLastPage())
                            <a href="{{$paginator->url($paginator->lastPage())}}"
                               class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                                    <path fill-rule="evenodd" d="M15.28 9.47a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L13.69 10 9.97 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25ZM6.03 5.22l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L8.69 10 4.97 6.28a.75.75 0 0 1 1.06-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                                    <path fill-rule="evenodd" d="M15.28 9.47a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L13.69 10 9.97 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25ZM6.03 5.22l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L8.69 10 4.97 6.28a.75.75 0 0 1 1.06-1.06Z" clip-rule="evenodd" />
                                </svg>
                                </span>
                            </span>
                        @endif
                </nav>
            </div>
        </div>
    </div>