<template>
    <li class="list-group-item">
        <span class="tag tag-default">#{{ quotation.id }}</span>
        {{ quotation.content }}
        <button class="btn btn-danger float-sm-right" @click="$parent.destroy(quotation)">
            <i class="fa fa-trash-o" aria-hidden="true"></i> 刪除
        </button>
    </li>
</template>

<script>
    export default {
        props: [
            'quotation'
        ]
    }
</script>
