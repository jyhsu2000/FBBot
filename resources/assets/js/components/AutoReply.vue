<template>
    <li class="list-group-item row">
        <div class="col-sm-1" style="white-space: nowrap">
            <span class="tag tag-default">#{{ autoReply.id }}</span>
        </div>
        <div class="col-sm-10">
            {{ autoReply.name }}
        </div>
        <div class="col-sm-1">
            <button class="btn btn-danger float-sm-right" @click="$parent.destroy(autoReply)">
                <i class="fa fa-trash-o" aria-hidden="true"></i> 刪除
            </button>
        </div>
    </li>
</template>

<script>
    export default {
        props: [
            'autoReply'
        ]
    }
</script>
