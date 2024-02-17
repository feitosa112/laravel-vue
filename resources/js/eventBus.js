import { createApp } from 'vue';

const app = createApp({});
const eventBus = app.config.globalProperties.$bus = new app();

export default eventBus;
