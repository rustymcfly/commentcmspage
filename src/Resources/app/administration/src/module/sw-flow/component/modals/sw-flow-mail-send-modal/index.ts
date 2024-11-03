export default {
    computed: {
        entityAware() {
            const awares = this.$super('entityAware');
            awares.push('CommentAware')
            return awares
        },
    }
}
