<?php

use function Livewire\Volt\{state, with};

state(['task', 'todo', 'editTask']);

with([
    'todos' => fn() => auth()->user()->todos,
]);

$add = function () {

    auth()->user()->todos()->create([
        'task' => $this->task
    ]);
};

$delete = fn(\App\Models\Todo $todo) => $todo->delete();

$edit = function (\App\Models\Todo $todo) {
    $this->editTask = $todo->task;
    $this->todo = $todo;
};

$update = function () {
    $this->todo->task = $this->editTask;
    $this->todo->save();
    $this->dispatch('close-modal', 'edit-task-modal');
};
?>


<div>
    <section class="p-10">
        <form wire:submit.prevent="add">
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input type="text" id="title" wire:model="task" />
            <x-secondary-button type="submit">Add</x-secondary-button>
        </form>
    </section>
    <div>
        @foreach ($todos as $todo)
            <div class="flex p-2 transition hover:transition-all hover:bg-gray-100 rounded-lg justify-between items-center">
                <span>{{ $todo->task }}</span>
                <div class="flex">
                    <button class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500"
                        wire:click="edit({{ $todo->id }})" x-on:click.prevent="$dispatch('open-modal', 'edit-task-modal')">
                        <x-heroicon-o-pencil-square class="h-5 w-5" />
                    </button>
                    <button class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 ml-2"
                        wire:click="delete({{ $todo->id }})">
                        <x-heroicon-o-trash class="h-5 w-5" />
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    <x-modal maxWidth="sm" class=" bg-slate-800" name="edit-task-modal" :show="$errors->isNotEmpty()" focusable>
        <section class="p-10">
            <form wire:submit.prevent="update()">
                <x-input-label for="title_edit" :value="__('Title')" />
                <x-text-input type="text" id="title_edit" wire:model="editTask" />
                <!-- // sua missao eh descobrir como matar esse editTask e usar o todo.task pra ficar mais bonito
            //  esse jeito resolve mas por algum motivo que nao sei o qual agora, nao ta funcionando o todo.task
            // eh como se nao tivesse entrando nas propriedades do model definido no state -->
                <x-secondary-button type="submit">Save</x-secondary-button>
            </form>
        </section>
    </x-modal>
</div>