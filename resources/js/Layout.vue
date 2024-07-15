<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <main>
    <header>
      <v-btn
        color="primary"
        href="/"
        style="cursor:pointer;"
      >
        Home
      </v-btn>

      <v-btn
        color="primary"
        href="/report"
        class="ml-2"
        style="cursor:pointer;"
      >
        Report
      </v-btn>
    </header>

    <article>
      <slot />
    </article>
  </main>
</template>