<template>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Order</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody v-sortable="{ onUpdate: onUpdate, handle: '.handle' }">
            <tr v-for="question in questions">
                <td>
                    <i class="fa fa-arrows-v fa-2x btn btn-secondary handle" aria-hidden="true"></i>
                </td>
                <td>{{ question.order }}</td>
                <td>
                    {{ question.content }}<br/>
                    <ul>
                        <template v-for="choice in question.choices">
                            <li class="text-primary" v-if="choice.is_correct">{{ choice.content }}</li>
                            <li v-else>{{ choice.content }}</li>
                        </template>
                    </ul>
                </td>
                <td>
                    <a href="{{ api }}/{{ question.id }}" class="btn btn-primary">
                        <i class="fa fa-search" aria-hidden="true"></i> 檢視/編輯
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
    export default {
        ready() {
            this.$nextTick(function () {
                this.fetch();
            });
        },
        data: function () {
            return {
                questions: []
            }
        },
        props: [
            'api'
        ],
        methods: {
            fetch: function () {
                this.$http.get(this.api + '/data').then(function (response) {
                    this.questions = response.json();
                });
            },
            onUpdate: function (event) {
                this.questions.splice(event.newIndex, 0, this.questions.splice(event.oldIndex, 1)[0]);
                var idList = [];
                $.each(this.questions, function (key, question) {
                    idList.push(question.id);
                });
                //發送請求
                this.$http.post(this.api + '/sort', {
                    idList: idList
                }).then(function (response) {
                    //重新獲取資料
                    this.fetch();
                    //顯示通知
                    alertify.notify('排序已更新', 'success', 5);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            }
        }
    }
</script>
