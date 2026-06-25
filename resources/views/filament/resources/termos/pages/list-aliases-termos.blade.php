<x-filament-panels::page>
    <div class="space-y-6">
        

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 text-left text-sm font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-3">Termo oficial</th>
                            <th class="px-4 py-3">Aliases</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white text-sm text-gray-700 dark:divide-gray-700 dark:bg-gray-900 dark:text-gray-200">
                        @forelse($termos as $termo)
                            <tr>
                                <td class="px-4 py-3 align-top">{{ $termo->nome_oficial }}</td>
                                <td class="px-4 py-3">
                                    @if($termo->aliases->isEmpty())
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Sem aliases</span>
                                    @else
                                        <ul class="space-y-1">
                                            @foreach($termo->aliases as $alias)
                                                <li class="rounded-md bg-gray-100 px-3 py-1 text-sm text-gray-700 shadow-sm dark:bg-gray-800 dark:text-gray-200">{{ $alias->nome }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">Nenhum termo encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
