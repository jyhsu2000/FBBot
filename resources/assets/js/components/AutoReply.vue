<template>
    <div class="list-group-item row">
        <div class="col-sm-1">
            <i class="fa fa-arrows-v fa-2x btn btn-secondary handle" aria-hidden="true"></i>
        </div>
        <div class="col-sm-1" style="white-space: nowrap">
            <span class="tag tag-default">#{{ reply.id }}</span>
        </div>
        <div class="col-sm-9">
            {{ reply.name }}
        </div>
        <div class="col-sm-1">
            <button class="btn btn-danger float-sm-right" @click="$parent.destroy(reply)">
                <i class="fa fa-trash-o" aria-hidden="true"></i> 刪除
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'reply'
        ]
    }
</script>
