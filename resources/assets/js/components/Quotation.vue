<template>
    <li class="list-group-item">
        {{ quotation.content }}
    </li>
</template>

<script>
    export default {
        props: [
            'quotation'
        ]
    }
</script>
