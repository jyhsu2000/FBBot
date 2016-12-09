<template>
    <div class="card">
        <div class="card-header">
            問題描述
        </div>
        <div class="card-block">
            <p class="card-text" v-if="!editMode">
                <i class="fa fa-pencil btn btn-primary" aria-hidden="true" @click="editMode = true"></i>
                {{ question.content }}
            </p>
            <form @submit.prevent="submit" v-else>
                <textarea class="form-control" required v-model="questionInput">{{ question.content }}</textarea>
                <input type="submit" value="更新" class="btn btn-primary" :disabled="question.content.length <= 0"/>
                <button class="btn btn-secondary" @click.prevent="editMode = false">取消</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            選項
        </div>
        <div class="card-block">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Order</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="choice in question.choices">
                    <td>{{ choice.id }}</td>
                    <td>{{ choice.order }}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-secondary">
                            <i class="fa fa-check fa-fw fa-2x text-success" aria-hidden="true"
                               v-if="choice.is_correct"></i>
                            <i class="fa fa-times fa-fw fa-2x text-danger" aria-hidden="true" v-else></i>
                        </a>
                        {{ choice.content }}
                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
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
                editMode: false,
                questionInput: '',
                question: {
                    content: 'Loading...',
                    choices: []
                }
            }
        },
        props: [
            'api',
            'question_id'
        ],
        methods: {
            fetch: function () {
                this.$http.get(this.api + '/get/' + this.question_id).then(function (response) {
                    this.question = response.json();
                });
            },
            submit: function () {
                var input = this.questionInput;
                //去除頭尾空白
                input = $.trim(input);
                //檢查輸入
                if (input.length == 0) {
                    return;
                }
                console.log('submit:' + input);
                //發送請求
                this.$http.patch(this.api + '/' + this.question_id, {
                    content: input
                }).then(function (response) {
                    var json = response.json();
                    console.log(json);
                    if (json.success != true) {
                        window.errorMessage = '';
                        $.each(json.errors, function (field, item) {
                            $.each(item, function (key, value) {
                                window.errorMessage += '<br/>' + field + ':' + value;
                            });
                        });
                        alertify.notify('更新失敗' + window.errorMessage, 'warning', 5);
                        return;
                    }
                    //即時顯示
                    this.question.content = json.content;
                    //顯示通知
                    alertify.notify('已更新', 'success', 5);
                    //關閉輸入模式
                    this.editMode = false;
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
        }
    }
</script>
