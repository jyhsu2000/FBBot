<template>
    <div>
        <div class="card">
            <div class="card-header">
                題目描述 <i class="fa fa-pencil btn btn-primary" aria-hidden="true" @click="enableEditMode"></i>
            </div>
            <div class="card-block">
                <div class="card-text" v-if="!editMode">
                    <h3><span class="tag tag-default">問題描述</span></h3>
                    <p>{{ question.content }}</p>
                    <!-- FIXME: 無法作為HTML解析，導致無法實現多行顯示 -->
                    <h3><span class="tag tag-default">答對的說明</span></h3>
                    <p>{{ question.correct_message | escapeHtml | nl2br }}</p>
                    <h3><span class="tag tag-default">答錯的說明</span></h3>
                    <p>{{ question.wrong_message | escapeHtml | nl2br }}</p>
                </div>
                <form @submit.prevent="submit" v-else>
                    <label for="question">問題描述</label>
                    <textarea id="question" class="form-control" required v-model="questionInput"></textarea>
                    <label for="correct_message">答對的說明</label>
                    <textarea id="correct_message" class="form-control" v-model="correctMessageInput"></textarea>
                    <label for="wrong_message">答錯的說明</label>
                    <textarea id="wrong_message" class="form-control" v-model="wrongMessageInput"></textarea>
                    <input type="submit" value="更新" class="btn btn-primary" :disabled="question.content.length <= 0"/>
                    <button class="btn btn-secondary" @click.prevent="editMode = false">取消</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                選項
            </div>
            <div v-sortable="{ onUpdate: onUpdate, handle: '.handle' }">
                <template v-for="choice in question.choices">
                    <question-choice :choice="choice" :choice_api="choice_api"></question-choice>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$nextTick(function () {
                this.fetch();
            });
        },
        data: function () {
            return {
                editMode: false,
                questionInput: '',
                correctMessageInput: '',
                wrongMessageInput: '',
                question: {
                    choices: []
                }
            }
        },
        props: [
            'api',
            'choice_api',
            'question_id'
        ],
        methods: {
            fetch: function () {
                this.$http.get(this.api + '/get/' + this.question_id).then(function (response) {
                    this.question = response.body;
                });
            },
            submit: function () {
                var input = this.questionInput;
                var correctMessage = $.trim(this.correctMessageInput);
                var wrongMessage = $.trim(this.wrongMessageInput);
                //去除頭尾空白
                input = $.trim(input);
                //檢查輸入
                if (input.length == 0) {
                    return;
                }
                //發送請求
                this.$http.patch(this.api + '/' + this.question_id, {
                    content: input,
                    correct_message: correctMessage,
                    wrong_message: wrongMessage,
                }).then(function (response) {
                    var json = response.body;
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
                    this.fetch();
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
            onUpdate: function (event) {
                this.question.choices.splice(event.newIndex, 0, this.question.choices.splice(event.oldIndex, 1)[0]);
                var idList = [];
                $.each(this.question.choices, function (key, choice) {
                    idList.push(choice.id);
                });
                //發送請求
                this.$http.post(this.choice_api + '/sort', {
                    idList: idList
                }).then(function (response) {
                    //顯示通知
                    alertify.notify('排序已更新', 'success', 5);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            enableEditMode: function () {
                this.questionInput = this.question.content;
                this.correctMessageInput = this.question.correct_message;
                this.wrongMessageInput = this.question.wrong_message;
                this.editMode = true;
            }
        }
    }
</script>
