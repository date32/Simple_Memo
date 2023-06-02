<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    user: Array,
});
</script>

<template>
    <Head title="Simple Memo" />

    <div class="bc8 he1">
        <div class="wi12 dis mcenter">
            <div class="original-text-shadow mt10">Simple Memo</div>
            <div class="mr dis f1-5">
                <div v-if="!user" class="mr20"><button onclick="location.href='/memo/login'" class="btn btn-primary mt20">ログイン</button></div>
                <div v-else class="mr20"><button onclick="location.href='/memo/logout'" class="btn btn-primary mt20">ログアウト</button></div>
                <div><button onclick="location.href='/memo/register'"  class="btn btn-primary mt20">新規登録</button></div>
            </div>
        </div>
        <div class="wi12 mcenter mt10 tr">\\ こんにちは{{ user.name }}さん //</div>
    </div>
</template>
<style>
.original-text-shadow {
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 1;
  color: #000000;
  font-size: 50px;
  text-shadow: 0px 20px 8px rgba(0, 0, 0, 0.4);
  font-weight: bold;
}
</style>