<template>
    {{-- FIXME --}}
    <li class="list-group-item"><slot></slot></li>
</template>

<script>
    export default {
        props: ['content'],
        ready() {
            console.log('Component ready.')
        }
    }
</script>
