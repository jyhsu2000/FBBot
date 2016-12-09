<template>
    <div class="card">
        <div class="card-header">
            題目描述 <i class="fa fa-pencil btn btn-primary" aria-hidden="true" @click="editMode = true"></i>
        </div>
        <div class="card-block">
            <div class="card-text" v-if="!editMode">
                <p>
                <h3><span class="tag tag-default">問題描述</span></h3>{{ question.content }}</p>
                <p>
                <h3><span class="tag tag-default">答對的說明</span></h3>{{ question.correct_message }}</p>
                <p>
                <h3><span class="tag tag-default">答錯的說明</span></h3>{{ question.wrong_message }}</p>
            </div>
            <form @submit.prevent="submit" v-else>
                <label for="question">問題描述</label>
                <textarea id="question" class="form-control" required
                          v-model="questionInput">{{ question.content }}</textarea>
                <label for="correct_message">答對的說明</label>
                <textarea id="correct_message" class="form-control" v-model="correctMessageInput">{{ question.correct_message }}</textarea>
                <label for="wrong_message">答錯的說明</label>
                <textarea id="wrong_message" class="form-control" v-model="wrongMessageInput">{{ question.wrong_message }}</textarea>
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
                    this.question = response.json();
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
                    var json = response.json();
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
            }
        }
    }
</script>
