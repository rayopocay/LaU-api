@extends('layouts.app-su')

@section('title', 'Perfiles')

@section('view-contenido')
<div class="relative flex flex-col flex-1 h-screen overflow-hidden">
            
    <header class="relative z-20 flex items-center justify-between h-20 px-4 transition-colors duration-300 bg-white shadow-sm dark:bg-gray-800 md:px-8 shrink-0">
        <div class="flex items-center">
            <button id="open-sidebar-button" class="mr-4 text-gray-500 dark:text-gray-200 focus:outline-none lg:hidden"><i class="fas fa-bars fa-2x"></i></button>
            <h2 class="text-xl font-bold text-gray-700 truncate md:text-2xl dark:text-white">Directorio de Usuarios</h2>
        </div>
        <div class="flex items-center gap-2">
            <span class="hidden px-3 py-1 text-xs font-bold text-indigo-700 bg-indigo-100 rounded-full md:inline-block">Total: {{ $totalUsers }}</span>
        </div>
    </header>

    <main class="relative flex flex-1 overflow-hidden transition-colors duration-300 bg-gray-50 dark:bg-gray-900">
        
        <div id="user-list-panel" class="absolute inset-y-0 left-0 z-10 flex flex-col w-full transition-transform duration-300 transform -translate-x-full bg-white border-r border-gray-200 shadow-2xl md:w-80 lg:w-96 dark:bg-gray-800 dark:border-gray-700 md:shadow-none md:translate-x-0 md:relative">
            
            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2 md:hidden">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200">Lista de Usuarios</h3>
                    <button onclick="toggleUserList()" class="text-gray-500"><i class="fas fa-times"></i></button>
                </div>
                <div class="relative mb-3">
                    <i class="absolute text-sm text-gray-400 fas fa-search left-3 top-3"></i>
                    <input type="text" id="search-input" data-url="{{ route('su.user.buscar') }}" placeholder="Buscar por nombre o correo..." class="w-full bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200 text-sm rounded-lg pl-9 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 border border-transparent focus:border-indigo-500 transition-all">
                </div>
                <div class="flex gap-2 pb-1 overflow-x-auto no-scrollbar">
                    <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 rounded-full whitespace-nowrap">Todos</button>
                    <button class="px-3 py-1 text-xs font-medium text-gray-600 transition bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 whitespace-nowrap">Activos</button>
                    <button class="px-3 py-1 text-xs font-medium text-gray-600 transition bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 whitespace-nowrap">Reportados</button>
                </div>
            </div>
            
            <div id="users-list-container" class="flex-1 p-2 space-y-1 overflow-y-auto custom-scrollbar">
                
                {{-- Llamada al componente dinámico --}}
                
                @include('components.listar-perfiles-su', ['users' => $users])



<!--                 <button onclick="showUser('user3')" id="btn-user3" class="flex items-center w-full p-3 transition-all border-l-4 border-transparent rounded-lg user-btn hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 group">
                    <div class="relative mr-3">
                        <img src="https://ui-avatars.com/api/?name=Carlos+R&background=random" class="object-cover w-10 h-10 rounded-full">
                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white dark:ring-gray-800 bg-red-500"></span>
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-medium text-gray-700 truncate dark:text-gray-200 group-hover:text-gray-900 dark:group-hover:text-white">Carlos Ruiz</h4>
                            <span class="bg-red-100 text-red-600 text-[9px] px-1.5 py-0.5 rounded font-bold">REPORTADO</span>
                        </div>
                        <p class="text-xs text-gray-500 truncate">Diseño Gráfico - UDB</p>
                    </div>
                </button> -->
            </div>
        </div>

        <div class="relative flex-1 w-full overflow-y-auto bg-gray-50 dark:bg-gray-900 custom-scrollbar">
            
            <button onclick="toggleUserList()" class="md:hidden absolute top-4 left-4 z-[5] bg-white dark:bg-gray-800 p-2 rounded-full shadow-lg text-indigo-600 border border-gray-200 dark:border-gray-700">
                <i class="fas fa-list"></i>
            </button>

            @foreach($users as $user)
            {{-- Solo mostramos el primero, los demas hidden --}}
            @php
                $urlId = request('user_id');
                // La misma lógica: activo si coincide con URL o si es el primero por defecto
                $isActive = $urlId ? ($urlId == $user->id) : $loop->first;
            @endphp
            <div id="detail-{{ $user->id }}" class="user-detail {{ $isActive ? '' : 'hidden' }} fade-in min-h-full">
                
                <div class="relative w-full h-32 md:h-48 bg-gradient-to-r from-indigo-600 to-blue-500">
                     <div class="absolute flex items-center px-3 py-1 text-xs font-bold text-white rounded-full shadow-sm top-4 right-4 bg-green-500/90 backdrop-blur-sm">
                        Activo
                    </div>
                </div>
                
                <div class="px-6 pb-10 md:px-10">
                    <div class="relative flex flex-col items-start mb-6 -mt-12 md:flex-row md:items-end">
                        <img src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : "https://ui-avatars.com/api/?name=".urlencode($user->name)."&size=128" }}" 
                             class="w-24 h-24 border-4 border-white rounded-full shadow-md md:h-32 md:w-32 dark:border-gray-900">
                        
                        <div class="flex-1 mt-4 md:mt-0 md:ml-4">
                            <div class="">
                               <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $user->name }} 
                                @if($user->insignias->contains('slug', 'verificado'))
                                    <i title="Estudiante Verificado" class='text-xl bx bxs-badge-check text-white-600'></i>
                                @endif
                               </h2>
                            </div>
                            
                            <p class="font-medium text-indigo-600 dark:text-indigo-400">{{ '@' . $user->username }}</p>
                            <!-- <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><i class="mr-1 fas fa-map-marker-alt"></i> San Salvador, El Salvador • Se unió en Ene 2024</p> -->
                        </div>
                        <div id="actions-{{ $user->id }}" class="mt-4 md:mt-0 flex gap-2 fade-in {{ $loop->first ? '' : 'hidden' }}">
                            <button class="px-4 py-2 text-sm font-medium text-white transition bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700">
                                <i class="mr-1 fas fa-edit"></i> Editar
                            </button>
                            <button class="px-3 py-2 text-gray-400 transition bg-white border border-gray-300 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-600 hover:text-red-500">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>

                    <div class="hidden p-4 mb-6 border-l-4 border-red-500 rounded-r bg-red-50 dark:bg-red-900/20">
                        <div class="flex">
                            <div class="flex-shrink-0"><i class="text-red-500 fas fa-info-circle"></i></div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 dark:text-red-300">Este usuario ha recibido <strong>3 reportes</strong> por comportamiento inapropiado en las últimas 24 horas.</p>
                            </div>
                        </div>
                    </div>

                    <div id="loading-body-{{ $user->id }}" class="flex-1 px-6 md:px-10 pb-10 {{ $isActive ? 'hidden' : '' }}">
                        <div class="p-10 mt-10 text-center text-gray-500">
                            <i class="mb-4 text-gray-300 fas fa-user fa-3x animate-pulse"></i>
                            <p class="text-lg">Perfil del Estudiante cargando...</p>
                        </div>
                    </div>

                    <div id="content-body-{{ $user->id }}" class="fade-in {{ $isActive ? '' : 'hidden' }}">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                            
                            <div class="flex flex-col h-full space-y-6">
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-[1.5rem] shadow-sm border border-gray-100 dark:border-gray-700">
                                    <h4 class="mb-4 text-sm font-bold tracking-wider text-gray-400 uppercase">Información Académica</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Universidad</p>
                                            <div class="flex items-center mt-1">
                                                <!-- <div class="h-6 w-6 bg-red-700 text-white text-[9px] flex items-center justify-center rounded font-bold mr-2">UES</div> -->
                                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                {{ $user->universidad?->nombre ?? 'No registrada' }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Carrera</p>
                                            <p class="mt-1 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $user->carrera?->nombre ?? 'No registrada' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Correo Institucional</p>
                                            <p class="mt-1 text-sm font-medium text-indigo-600 cursor-pointer dark:text-indigo-400 hover:underline">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white dark:bg-gray-800 p-6 rounded-[1.5rem] shadow-sm border border-gray-100 dark:border-gray-700 flex-1">
                                    <h4 class="mb-4 text-sm font-bold tracking-wider text-gray-400 uppercase">Insignia</h4>
                                    <div class="flex gap-3 text-xl">
                                        @foreach($user->insignias as $badge)
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center shadow-sm {{ $badge->bgicon }}" 
                                                 title="{{ $badge->nombre }}">
                                                {{-- Renderizamos el icono dinámico --}}
                                                <i class="{{ $badge->icono }}"></i>
                                            </div>
                                        @endforeach
                                        
                                        <button 
                                        onclick="openBadgeModal({{ $user->id }}, {{ $user->insignias->pluck('id') }})"
                                        class="flex items-center justify-center w-10 h-10 transition border-2 border-gray-400 border-dashed rounded-full hover:border-blue-500"
                                        >
                                            <i class="bi bi-patch-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6 lg:col-span-2">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="p-4 text-center bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
                                        <span class="block text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts_count }}</span>
                                        <span class="text-xs text-gray-500 uppercase">Posts</span>
                                    </div>
                                    <div class="p-4 text-center bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
                                        <span class="block text-2xl font-bold text-gray-900 dark:text-white">{{ $user->followers_count }}</span>
                                        <span class="text-xs text-gray-500 uppercase">Seguidores</span>
                                    </div>
                                    <div class="p-4 text-center bg-red-300 border border-red-700 shadow-sm dark:bg-red-600 rounded-xl dark:border-red-400">
                                        <span class="block text-2xl font-bold text-gray-900 dark:text-white">{{ $user->reportes_recibidos_count }}</span>
                                        <span class="text-xs text-gray-600 uppercase dark:text-white">Reportes</span>
                                    </div>
                                </div>

                                <div class="bg-white dark:bg-gray-800 p-6 rounded-[1.5rem] shadow-sm border border-gray-100 dark:border-gray-700">
                                    <h4 class="mb-4 text-lg font-bold text-gray-800 dark:text-white">Actividad Reciente</h4>
                                    <div class="relative pl-6 ml-2 space-y-6 border-l-2 border-gray-100 dark:border-gray-700">
                                        
                                        <div class="relative">
                                            <span class="absolute -left-[31px] top-1 h-4 w-4 rounded-full bg-indigo-500 border-2 border-white dark:border-gray-800"></span>
                                            <p class="mb-1 text-sm text-gray-500">Hace 2 horas</p>
                                            <p class="font-medium text-gray-800 dark:text-gray-200">Publicó un nuevo material de estudio: <span class="text-indigo-600">"Guía de Cálculo II"</span></p>
                                        </div>

                                        <div class="relative">
                                            <span class="absolute -left-[31px] top-1 h-4 w-4 rounded-full bg-green-500 border-2 border-white dark:border-gray-800"></span>
                                            <p class="mb-1 text-sm text-gray-500">Ayer</p>
                                            <p class="font-medium text-gray-800 dark:text-gray-200">Se le Otorgo la Insignia de: <span class="font-bold text-gray-700 dark:text-white">"Comunidad"</span></p>
                                        </div>

                                        <div class="relative">
                                            <span class="absolute -left-[31px] top-1 h-4 w-4 rounded-full bg-gray-300 border-2 border-white dark:border-gray-800"></span>
                                            <p class="mb-1 text-sm text-gray-500">20 Oct, 2025</p>
                                            <p class="font-medium text-gray-800 dark:text-gray-200">Actualizó su foto de perfil.</p>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="space-y-6 lg:col-span-3">
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-[1.5rem] shadow-sm border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-6">
                                        <h4 class="text-sm font-bold tracking-wider text-gray-400 uppercase">Estado Disciplinario</h4>
                                        
                                        {{-- Badge de Estado General --}}
                                        <span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 border border-green-200 rounded-md dark:bg-green-900/30 dark:text-green-400 dark:border-green-800">
                                            COMPORTAMIENTO BUENO
                                        </span>
                                    </div>

                                    <div class="relative flex items-center justify-between px-2 mb-6">
                                        <div class="absolute left-0 w-full h-1 bg-gray-100 rounded-full top-1/2 dark:bg-gray-700 -z-0"></div>
                                        
                                        <div class="relative z-10 flex flex-col items-center cursor-pointer group">
                                            <div class="flex items-center justify-center w-8 h-8 text-yellow-600 transition-transform bg-yellow-100 border-2 border-yellow-400 rounded-full shadow-sm hover:scale-110">
                                                <i class="fas fa-exclamation"></i>
                                            </div>
                                            <span class="absolute -bottom-6 text-[10px] font-semibold text-gray-500 dark:text-gray-400 whitespace-nowrap">Aviso</span>
                                        </div>

                                        <div class="relative z-10 flex flex-col items-center cursor-pointer group">
                                            <div class="flex items-center justify-center w-8 h-8 text-gray-300 bg-white border-2 border-gray-200 rounded-full dark:bg-gray-800 dark:border-gray-600">
                                                <span class="text-xs font-bold">1</span>
                                            </div>
                                            <span class="absolute -bottom-6 text-[10px] font-medium text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">1ª Falta</span>
                                        </div>

                                        <div class="relative z-10 flex flex-col items-center cursor-pointer group">
                                            <div class="flex items-center justify-center w-8 h-8 text-gray-300 bg-white border-2 border-gray-200 rounded-full dark:bg-gray-800 dark:border-gray-600">
                                                <span class="text-xs font-bold">2</span>
                                            </div>
                                             <span class="absolute -bottom-6 text-[10px] font-medium text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">2ª Falta</span>
                                        </div>

                                        <div class="relative z-10 flex flex-col items-center cursor-pointer group">
                                            <div class="flex items-center justify-center w-8 h-8 text-gray-300 bg-white border-2 border-gray-200 rounded-full dark:bg-gray-800 dark:border-gray-600">
                                                <span class="text-xs font-bold">3</span>
                                            </div>
                                             <span class="absolute -bottom-6 text-[10px] font-medium text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">3ª Falta</span>
                                        </div>

                                        <div class="relative z-10 flex flex-col items-center cursor-pointer group">
                                            <div class="flex items-center justify-center w-8 h-8 text-gray-300 bg-white border-2 border-gray-200 rounded-full dark:bg-gray-800 dark:border-gray-600">
                                                <i class="fas fa-ban"></i>
                                            </div>
                                             <span class="absolute -bottom-6 text-[10px] font-medium text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Expulsión</span>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 p-3 mt-8 border border-gray-100 bg-gray-50 dark:bg-gray-700/50 rounded-xl dark:border-gray-600">
                                        <div class="text-[22px] mt-0.5 text-yellow-500">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-[15px] font-bold text-gray-800 dark:text-white mb-0.5">Advertencia Reciente</p>
                                            <p class="text-[14px] text-gray-500 dark:text-gray-300 leading-tight">
                                                Se detectó lenguaje inapropiado en los comentarios del post "Matemáticas I".
                                            </p>
                                            <p class="text-[12px] text-gray-400 mt-2">Hace 2 días • Por Admin</p>
                                        </div>
                                    </div>
                                    
                                    <button class="w-full py-2 mt-4 text-xs font-medium text-indigo-600 transition rounded-lg dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20">
                                        Ver historial completo
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @endforeach

<!--             <div id="detail-user3" class="hidden min-h-full user-detail fade-in">
                <div class="relative w-full h-32 md:h-48 bg-gradient-to-r from-red-800 to-red-600">
                     <div class="absolute flex items-center px-3 py-1 text-xs font-bold text-white bg-red-600 rounded-full shadow-sm top-4 right-4">
                        <i class="mr-1 fas fa-exclamation-triangle"></i> REPORTADO
                    </div>
                </div>
                <div class="px-6 pb-10 md:px-10">
                    <div class="relative flex flex-col items-start mb-6 -mt-12 md:flex-row md:items-end">
                        <img src="https://ui-avatars.com/api/?name=Carlos+R&background=random&size=128" class="w-24 h-24 border-4 border-white rounded-full shadow-md md:h-32 md:w-32 dark:border-gray-900 grayscale">
                        <div class="flex-1 mt-4 md:mt-0 md:ml-4">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Carlos Ruiz</h2>
                            <p class="font-medium text-gray-500">@carlos_design</p>
                        </div>
                        <div class="flex gap-2 mt-4 md:mt-0">
                            <button class="px-4 py-2 text-sm font-bold text-white transition bg-red-600 rounded-lg shadow-sm hover:bg-red-700">
                                BLOQUEAR CUENTA
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-4 mb-6 border-l-4 border-red-500 rounded-r bg-red-50 dark:bg-red-900/20">
                        <div class="flex">
                            <div class="flex-shrink-0"><i class="text-red-500 fas fa-info-circle"></i></div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 dark:text-red-300">Este usuario ha recibido <strong>3 reportes</strong> por comportamiento inapropiado en las últimas 24 horas.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->

        </div>
    </main>
</div>

<div id="badge-modal" class="fixed inset-0 z-50 hidden overflow-y-auto transition-opacity duration-300 backdrop-blur-sm" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center items-end justify-center min-h-screen px-4 py-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" aria-hidden="true" onclick="toggleModal('badge-modal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-[1.5rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form id="assignBadgesForm" action="{{ route('su.add.insig') }}" method="POST">
            @csrf

                <input type="hidden" name="user_id" id="modal-user-id" value="">
                <div class="px-4 pt-5 pb-4 bg-white dark:bg-gray-800 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-indigo-100 rounded-full dark:bg-indigo-900 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="text-indigo-600 bi bi-patch-plus dark:text-indigo-400"></i>
                        </div>
                        <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">Administrar Insignias</h3>
                            
                            <div class="mt-4 space-y-4">
                                
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Seleccionar Insignia</label>
                                    <div class="flex gap-2">
                                        <select id="badge-select" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                                            <option value="" disabled selected>Selecciona una insignia</option>
                                            
                                            {{-- Iteramos sobre la variable $insignia que enviaste desde el controller --}}
                                            @foreach($insignia as $badge)
                                                {{-- Value: El ID (para guardarlo en la BD) --}}
                                                {{-- Text: El Nombre (para que el usuario lo lea) --}}
                                                <option value="{{ $badge->id }}">{{ $badge->nombre }}</option>
                                            @endforeach

                                        </select>
                                        <button type="button" onclick="addBadge()" class="inline-flex justify-center px-4 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none sm:text-sm">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Insignias Asignadas</label>
                                    <div id="badge-list" class="flex flex-col space-y-2 p-1 min-h-[80px]">
                                        <p id="empty-badges-msg" class="w-full py-4 text-xs text-center text-gray-400">No hay insignias asignadas aún.</p>
                                    </div>
                                </div>

                                <input type="hidden" name="badges" id="badges-input" value="">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="gap-2 px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex sm:flex-row-reverse sm:px-8">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Guardar Cambios
                    </button>
                    
                    {{-- BOTÓN CANCELAR (Tipo BUTTON) --}}
                    <button type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="toggleModal('badge-modal')">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalID) {
        document.getElementById(modalID).classList.toggle("hidden");
    }

    // Configuración visual de las insignias
    const badgeConfig = {};

    @foreach($insignia as $badge)
        // Usamos el ID como clave (ej: badgeConfig[1], badgeConfig[5])
        badgeConfig["{{ $badge->id }}"] = {
            label: "{{ $badge->nombre }}",
            desc: "{{ $badge->descripcion ?? 'Sin descripción' }}",
            icon: "{{ $badge->icono }}",
            // Usamos el campo bgicon que guardaste (ej: 'bg-blue-100 text-blue-600')
            bgIcon: "{{ $badge->bgicon }}", 
            // Estilo por defecto para la tarjeta
            bgCard: "bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600"
        };
    @endforeach

    let selectedBadges = [];

    function openBadgeModal(userId, currentBadgesIds) {
        // Asignar el ID del usuario al input oculto
        document.getElementById('modal-user-id').value = userId;

        // Convertir los IDs que vienen de PHP a strings (para que coincidan con badgeConfig)
        // currentBadgesIds viene como array de números: [1, 2]
        if (Array.isArray(currentBadgesIds)) {
            selectedBadges = currentBadgesIds.map(id => id.toString());
        } else {
            selectedBadges = [];
        }
        // Renderizar visualmente las que ya tiene
        renderBadges();

        // Mostrar el modal
        toggleModal('badge-modal');
    }

    function addBadge() {
        const select = document.getElementById('badge-select');
        const badgeKey = select.value;

        if (!badgeKey) return; // Si no seleccionó nada
        if (selectedBadges.includes(badgeKey)) return; // Evitar duplicados

        selectedBadges.push(badgeKey);
        renderBadges();
        
        // Resetear select
        select.value = "";
    }

    function removeBadge(badgeKey) {
        selectedBadges = selectedBadges.filter(b => b !== badgeKey);
        renderBadges();
    }

    function renderBadges() {
        const container = document.getElementById('badge-list');
        const emptyMsg = document.getElementById('empty-badges-msg');
        const input = document.getElementById('badges-input');

        container.innerHTML = '';
        container.appendChild(emptyMsg); 

        if (selectedBadges.length === 0) {
            emptyMsg.classList.remove('hidden');
        } else {
            emptyMsg.classList.add('hidden');

            selectedBadges.forEach(key => {
                // Validación por si la insignia fue borrada de la BD pero el usuario la tenía
                if (!badgeConfig[key]) return; 

                const config = badgeConfig[key];
                
                const badgeEl = document.createElement('div');
                badgeEl.className = `flex items-center justify-between w-full p-3 rounded-xl border shadow-sm mb-2 transition-all animate-fade-in-up ${config.bgCard}`;
                
                badgeEl.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full flex items-center justify-center ${config.bgIcon}">
                            <i class="${config.icon} text-xl"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold leading-none text-gray-800 dark:text-white">${config.label}</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">${config.desc}</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeBadge('${key}')" class="p-2 text-gray-400 transition-colors rounded-lg hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
                container.appendChild(badgeEl);
            });
        }
        
        // Actualizamos el input que se enviará al servidor
        input.value = JSON.stringify(selectedBadges);
    }

    // Guardar
    function saveBadges() {
        const badgesToSend = document.getElementById('badges-input').value;
        console.log("Enviando:", badgesToSend);
        toggleModal('badge-modal');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const resultsContainer = document.getElementById('users-list-container');

        // --- TRIGGER DE CARGA INICIAL ---
        const activeDetailDiv = document.querySelector('.user-detail:not(.hidden)');
        if (activeDetailDiv) {
            const activeUserId = activeDetailDiv.id.replace('detail-', '');
            
            const loadingBody = document.getElementById('loading-body-' + activeUserId);
            const contentBody = document.getElementById('content-body-' + activeUserId);
            const actionButtons = document.getElementById('actions-' + activeUserId);

            if(loadingBody && contentBody) {
                // Mostrar "Cargando..."
                loadingBody.classList.remove('hidden');
                contentBody.classList.add('hidden');
                if(actionButtons) actionButtons.classList.add('hidden');

                // Quitar el "Cargando..." y poner el "Fade-In"
                setTimeout(() => {
                    loadingBody.classList.add('hidden');
                    contentBody.classList.remove('hidden');
                    contentBody.classList.add('fade-in');
                    if(actionButtons) {
                        actionButtons.classList.remove('hidden');
                        actionButtons.classList.add('fade-in');
                    }
                }, 600);
            }
        }

        if (searchInput && resultsContainer) {
            const urlDestino = searchInput.dataset.url;
            
            // Variables para controlar la búsqueda
            let debounceTimer; 
            let currentController = null; // Para cancelar peticiones viejas

            searchInput.addEventListener('keyup', function() {
                const query = this.value;

                // 1. Limpiar el temporizador anterior (Debounce)
                clearTimeout(debounceTimer);

                // 2. Cancelar la petición anterior si todavía se está cargando
                if (currentController) {
                    currentController.abort();
                }

                // 3. Crear un nuevo temporizador (esperamos 300ms)
                debounceTimer = setTimeout(() => {
                    
                    // Preparamos el controlador de cancelación para esta nueva petición
                    currentController = new AbortController();
                    const signal = currentController.signal;

                    // Mostramos un estado de carga opcional (opacidad, spinner, etc)
                    resultsContainer.style.opacity = '0.5';

                    fetch(`${urlDestino}?buscar=${encodeURIComponent(query)}`, { signal: signal })
                        .then(response => response.text())
                        .then(html => {
                            resultsContainer.innerHTML = html;
                            resultsContainer.style.opacity = '1';
                        })
                        .catch(error => {
                            // Si el error es por "abort", no hacemos nada (es intencional)
                            if (error.name === 'AbortError') {
                                console.log('Búsqueda anterior cancelada');
                            } else {
                                console.error('Error:', error);
                                resultsContainer.style.opacity = '1';
                            }
                        });

                }, 300); // 300ms de espera antes de buscar
            });
        }
    });

    let loadTimeout;

    function showUser(userId) {
        // 
        if(loadTimeout) clearTimeout(loadTimeout);

        // 2. Actualizar estilos del BOTÓN (Tu código actual)
        document.querySelectorAll('.user-btn').forEach(btn => {
            btn.classList.remove('bg-indigo-50', 'dark:bg-indigo-900/30', 'border-indigo-600', 'text-indigo-600');
            btn.classList.add('border-transparent', 'hover:border-gray-300');
        });

        const activeBtn = document.getElementById('btn-' + userId);
        if(activeBtn) {
            activeBtn.classList.remove('border-transparent', 'hover:border-gray-300', 'text-gray-500');
            activeBtn.classList.add('bg-indigo-50', 'dark:bg-indigo-900/30', 'border-indigo-600');
        }

        // ponemos TODOS los textos en gris
        document.querySelectorAll('.user-role-text').forEach(p => {
            p.classList.remove('text-indigo-600', 'dark:text-indigo-400');
            p.classList.add('text-gray-500');
        });

        // ponemos SOLO el texto del usuario seleccionado en índigo
        const activeText = document.getElementById('text-' + userId);
        if(activeText) {
            activeText.classList.remove('text-gray-500');
            activeText.classList.add('text-indigo-600', 'dark:text-indigo-400');
        }

        // --- LÓGICA DE CARGA ESPECÍFICA ---

        // Ocultar todos los paneles principales
        document.querySelectorAll('.user-detail').forEach(el => el.classList.add('hidden'));

        // Mostrar el panel principal del usuario seleccionado
        const selectedDetail = document.getElementById('detail-' + userId);
        if(selectedDetail) {
            selectedDetail.classList.remove('hidden');

            // RESETEAR ESTADO: Mostrar "Loading" y Ocultar "Content"
            const loadingBody = document.getElementById('loading-body-' + userId);
            const contentBody = document.getElementById('content-body-' + userId);
            const actionButtons = document.getElementById('actions-' + userId);

            if(loadingBody) loadingBody.classList.remove('hidden');
            if(contentBody) contentBody.classList.add('hidden');
            if(actionButtons) actionButtons.classList.add('hidden');

            // SIMULAR CARGA
            loadTimeout = setTimeout(() => {
                // Ocultar carga
                if(loadingBody) loadingBody.classList.add('hidden');
                
                // Mostrar contenido real con efecto fade
                if(contentBody) {
                    contentBody.classList.remove('hidden');
                    contentBody.classList.remove('fade-in');
                    void contentBody.offsetWidth; 
                    contentBody.classList.add('fade-in');
                }

                if(actionButtons) {
                    actionButtons.classList.remove('hidden');
                    actionButtons.classList.remove('fade-in');
                    void actionButtons.offsetWidth; 
                    actionButtons.classList.add('fade-in');
                }
                
            }, 600);
        }

        // cerrar la lista después de seleccionar
        if(window.innerWidth < 768) { 
            document.getElementById('user-list-panel').classList.add('-translate-x-full');
        }

        if (history.pushState) {
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('user_id', userId);
            window.history.pushState({path: newUrl.href}, '', newUrl.href);
        }
    }

    

    // LÓGICA DE LISTA EN MÓVIL (OFF-CANVAS)
    function toggleUserList() {
        const panel = document.getElementById('user-list-panel');
        panel.classList.toggle('-translate-x-full');
    }
</script>
@endsection