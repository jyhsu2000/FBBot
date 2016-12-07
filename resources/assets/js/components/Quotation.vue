<template>
    <li class="list-group-item row">
        <div class="col-sm-1" style="white-space: nowrap">
            <span class="tag tag-default">#{{ quotation.id }}</span>
            <span class="tag tag-primary">{{ quotation.counter }}</span>
        </div>
        <div class="col-sm-10">
            {{ quotation.content }}
        </div>
        <div class="col-sm-1">
            <button class="btn btn-danger float-sm-right" @click="$parent.destroy(quotation)">
                <i class="fa fa-trash-o" aria-hidden="true"></i> 刪除
            </button>
        </div>
    </li>
</template>

<script>
    export default {
        props: [
            'quotation'
        ]
    }
</script>
