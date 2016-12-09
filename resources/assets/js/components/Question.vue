<template>
    <div class="card">
        <div class="card-header">
            問題描述
        </div>
        <div class="card-block">
            <p class="card-text">
                {{ question.content }}
            </p>
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
                        <span v-if="choice.is_correct">
                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                        </span>
                        <span v-else>
                            <i class="fa fa-times text-danger" aria-hidden="true"></i>
                        </span>
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
                question: {
                    content: 'Loading...',
                    choices: []
                }
            }
        },
        props: [
            'api'
        ],
        methods: {
            fetch: function () {
                this.$http.get(this.api).then(function (response) {
                    this.question = response.json();
                });
            }
        }
    }
</script>
