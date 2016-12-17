<template>
    <div class="list-group-item row">
        <div class="col-sm-1">
            <i class="fa fa-arrows-v fa-2x btn btn-secondary handle" aria-hidden="true"></i>
        </div>
        <div class="col-sm-1" style="white-space: nowrap">
            <span class="tag tag-default">#{{ reply.id }}</span>
        </div>
        <div class="col-sm-9">
            <i class="fa fa-pencil btn btn-primary" aria-hidden="true" @click="editName"></i>
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
        ],
        methods: {
            editName: function () {
                var oldName = this.reply.name;
                var newName = prompt("請輸入新名稱", oldName);
                if (newName == oldName || newName == null || newName.length == 0) {
                    return;
                }
                this.$parent.updateName(this.reply, newName);
            }
        }
    }
</script>
