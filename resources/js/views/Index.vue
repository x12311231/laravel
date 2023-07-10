<script setup>
import { useForm } from 'laravel-precognition-vue';

const form = useForm('post', '/users', {
    name: '',
    email: '',
    password: ''
});

const submit = () => form.submit();
</script>

<template>
    <form @submit.prevent="submit">
        <label for="name">Name</label>
        <input
            id="name"
            v-model="form.name"
            @input="form.validate('name')"
        />
        <div v-if="form.invalid('name')">
            {{ form.errors.name }}
        </div>

        <label for="email">Email</label>
        <input
            id="email"
            type="email"
            v-model="form.email"
            @change="form.validate('email')"
        />
        <div v-if="form.invalid('email')">
            {{ form.errors.email }}
        </div>

        <label for="password">Email</label>
        <input
            id="password"
            type="password"
            v-model="form.password"
            @change="form.validate('password')"
        />
        <div v-if="form.invalid('password')">
            {{ form.errors.password }}
        </div>

        <button>Create User</button>
    </form>
</template>
