const Storage = {
    init() {
        this.storage = localStorage;
        return this;
    },

    add(key, value) {
        this.storage.setItem(key, JSON.stringify(value));

        return true;
    },

    get(key) {
        const element = this.storage.getItem(key);

        return JSON.parse(element) || undefined;
    },

    remove(key) {
        this.storage.removeItem(key);
    }
}

export default Storage.init();