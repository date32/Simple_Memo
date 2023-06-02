<script setup>
import { formToJSON } from 'axios';
import { Head, Link } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import moment from 'moment';
import axios from 'axios';

defineProps({
    user: Array,
    memos: Array,
});
</script>

<template>
    <div>
        <Header :user="user" />
    </div>


    <!-- 新規登録 --> <!-- 検索 -->
    <div class="mb30">
        <div class="wi12 mcenter he1">
            <div class="dis">
                <div class="wi6">
                    <div class="f1-5 mt20">メモの新規登録</div>
                    <input type="text" v-model="memo" class="wi4-5 mr20">
                    <button @click="store()" class="btn btn-primary"><i class="fa-solid fa-check"></i>登録</button>
                    <div class="c3">
                        <p v-if="error">必須項目です</p>
                        <p v-if="error3">100字未満で入力してください</p>
                        <p v-if="msg">{{ msg }}</p>
                    </div>
                </div>
                <div class="wi5 mr">
                    <div class="f1-5 mt20">メモの検索</div>
                    <input type="text" v-model="searchQuery" class="wi3 mr20" placeholder="検索キーワードを入力してください" />
                    <button @click="search()" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>検索</button>
                    <p v-if="error4" class="c3">入力してください</p>
                </div>
            </div>
        </div>
        <div class="bb mt30 wi12 mcenter"></div>
    </div>


    <div class="dis wi12 mcenter">

        <!-- 一覧 --><!-- 検索結果 -->
        <div class="mb30">
            <!-- 一覧 -->
            <div v-if="list">
                <div class="f1-5">メモ一覧</div>
                <table>
                    <tr class="bb">
                        <th width="30px">No.</th>
                        <th width="300px">メモ内容</th>
                        <th width="100px">作成日時</th>
                        <th width="100px">更新日時</th>
                        <th width="80px"></th>
                        <th width="80px"></th>
                    </tr>
                    <tr v-for="(memo, index) in memos" :key="memo.id" class="bbd he0-5">
                        <td>{{ index + 1 }}</td>
                        <td>{{ memo.memo }}</td>
                        <td>{{ formDate(memo.created_at) }}</td>
                        <td>{{ formDate(memo.updated_at) }}</td>
                        <td><button @click="editMode(memo)" class="btn btn-success"><i class="fa-sharp fa-solid fa-pen-nib"></i>編集</button></td>
                        <td><button @click="del(memo.id)" class="btn btn-danger"><i class="fa fa-trash"></i>削除</button></td>
                    </tr>
                </table>
            </div>
            <div v-if="!list">
                <div v-if="searchResults.length > 0">
                    <div class="dis">
                        <div class="f1-5 mr20">検索結果</div>
                        <div>
                            <button @click="goList()" class="btn btn-info">一覧へ戻る</button>
                        </div>
                    </div>
                    <table>
                        <tr class="bb">
                            <th width="30px">No.</th>
                            <th width="300px">メモ内容</th>
                            <th width="100px">作成日時</th>
                            <th width="100px">更新日時</th>
                            <th width="80px"></th>
                            <th width="80px"></th>
                        </tr>
                        <tr v-for="(memo, index) in searchResults" :key="memo.id" class="bbd he0-5">
                            <td>{{ index + 1 }}</td>
                            <td>{{ memo.memo }}</td>
                            <td>{{ formDate(memo.created_at) }}</td>
                            <td>{{ formDate(memo.updated_at) }}</td>
                            <td><button @click="editMode(memo)" class="btn btn-success"><i class="fa-sharp fa-solid fa-pen-nib"></i>編集</button></td>
                            <td><button @click="del(memo.id)" class="btn btn-danger"><i class="fa fa-trash"></i>削除</button></td>
                        </tr>
                    </table>
                </div>
                <div v-else>
                    <p v-if="error5">該当するメモは見つかりませんでした。</p>
                    <button @click="goList()" class="btn btn-info">一覧へ戻る</button>
                </div>
            </div>
        </div>

        <!-- 編集 -->
        <div class="mt30 ml50">          
            <div v-if="edit">
                <div class="f1-5">メモの編集</div>
                <td><input type="text" :placeholder=editMemo v-model="editingMemo" class="wi3 mr20"></td>
                <td><button @click="update(editId)" v-if="edit" class="btn btn-primary mr20">修正</button></td>
                <td><button @click="editModeEnd()" v-if="edit" class="btn btn-info">戻る</button></td>
                <p v-if="error2">必須項目です</p>
                <p v-if="error3">100字未満で入力してください</p>
            </div>
        </div>
    </div>


</template>




<script>
export default {
    data() {
        return {
            memo: '',
            error: false,
            error2: false,
            error3: false,
            error4: false,
            error5: false,
            edit: false,
            editId: '',
            editingMemo: '',
            editMemo: '',
            msg: '',
            list: true,
            searchQuery: '',
            searchResults: '',





        }
    },
    props: {
    },
    methods: {
        formDate(date) {
            return moment(date).format('YYYY-MM-DD');
        },
        store() {
            if (this.memo) {
                if (this.memo.length >= 100) {
                    this.error3 = true;
                } else {
                    this.error = false;
                    const data = {
                        memo: this.memo,
                    }
                    axios.post('/memo/store', data)
                        .then(response => {
                            this.memos.push(response.data)
                            this.memo = '';
                            this.error = false;
                            this.error3 = false;
                            this.msg = '新しく登録しました';
                            this.list = true;
                            // this.$inertia.reload(); //一部分を再表示する（リロードではない）
                            // location.reload(); //リロード
                        })
                        .catch(error => {
                        });
                }
            } else {
                this.error = true;
            }
        },
        del(id) {
            if (confirm('本当に削除しますか？')) {
                axios.post(`/memo/delete/${id}`)
                    .then(response => {
                        const index = this.memos.findIndex(memo => memo.id === id);
                        this.memos.splice(index, 1);
                        // this.$inertia.reload(); //一部分を再表示する
                        // location.reload(); //リロード
                    })
                    .catch(error => {
                    });
            } else {
                return false;
            }
        },
        editMode(memo) {
            this.error2 = false;
            this.error3 = false;
            this.edit = true;
            this.editId = memo.id;
            this.editMemo = memo.memo;
        },
        editModeEnd() {
            this.error2 = false;
            this.error3 = false;
            this.edit = false;
            this.editId = '';
            this.editingMemo = '';
            this.editMemo = '';
        },
        update(id) {
            if (this.editingMemo) {
                this.error2 = false;
                const data = {
                    memo: this.editingMemo,
                }
                axios.post(`/memo/update/${id}`, data)
                    .then(response => {
                        this.editModeEnd();
                        // this.$inertia.reload(); //一部分を再表示する
                        location.reload(); //リロード
                    })
                    .catch(error => {
                    });
            } else {
                this.error2 = true;
            }
        },
        search() {
            this.list = false;
            if (this.searchQuery) {
                this.error4 = false;
                this.error5 = false;
                const query = this.searchQuery.toLowerCase(); // 検索クエリを小文字に変換するなど、適宜処理を追加してください
                const searchResults = this.memos.filter(memo => memo.memo.toLowerCase().includes(query));
                this.searchResults = searchResults;
            } else {
                this.error4 = true;
                this.error5 = true;
                this.searchResults = '';

            }
        },
        goList() {
            this.list = true;
        },

    },


}

</script>

