const Storage = {
    init() {
        this.storage = localStorage
    },

    add(key, value) {
        this.storage.setItem(key, JSON.stringify(value));
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