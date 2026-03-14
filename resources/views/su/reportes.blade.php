@extends('layouts.app-su')

@section('title', 'Gestión de Reportes')

@section('view-contenido')
    <div class="relative flex flex-col flex-1 h-screen overflow-hidden">
        <header
            class="relative z-20 flex items-center justify-between h-20 px-4 transition-colors duration-300 bg-white shadow-sm dark:bg-gray-800 md:px-8 shrink-0">
            <div class="flex items-center">
                <button id="open-sidebar-button" class="mr-4 text-gray-500 dark:text-gray-200 focus:outline-none lg:hidden">
                    <i class="fas fa-bars fa-2x"></i>
                </button>
                <h2 class="text-xl font-bold text-gray-700 truncate md:text-2xl dark:text-white">Gestión de Reportes</h2>
            </div>
        </header>

        <main class="flex-1 p-4 overflow-y-auto bg-gray-50 dark:bg-gray-900 md:p-8">
            <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-sm text-gray-500 border-b dark:border-gray-700 dark:text-gray-400">
                                <th class="py-3 font-semibold">ID</th>
                                <th class="py-3 font-semibold">Reportador</th>
                                <th class="py-3 font-semibold">Reportado</th>
                                <th class="py-3 font-semibold">Motivo</th>
                                <th class="py-3 font-semibold">Fecha</th>
                                <th class="py-3 font-semibold">Estado</th>
                                <th class="py-3 text-center font-semibold">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($reportes as $reporte)
                                <tr
                                    class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-700 dark:text-gray-300">
                                    <td class="py-4 font-medium">#{{ $reporte->id }}</td>
                                    <td class="py-4 text-blue-600 dark:text-blue-400">
                                        {{ $reporte->reporter->username ?? 'Usuario Eliminado' }}
                                    </td>
                                    <td class="py-4 font-semibold text-red-600 dark:text-red-400">
                                        {{ $reporte->reportedUser->username ?? 'Usuario Eliminado' }}
                                    </td>
                                    <td class="py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full">
                                            {{ $reporte->motivo }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-gray-500">{{ $reporte->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-4">
                                        @if ($reporte->estado === 'pendiente')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pendiente</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Resuelto</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center">
                                        <button
                                            class="px-3 py-1 text-xs text-white transition bg-indigo-600 rounded hover:bg-indigo-700">
                                            Revisar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        <i class="mb-2 text-4xl fas fa-check-circle text-emerald-500"></i>
                                        <p>No hay reportes en el sistema. ¡Todo está tranquilo!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $reportes->links() }}
                </div>
            </div>
        </main>
    </div>
@endsection
