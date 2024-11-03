import template from './template.html.twig'

const {Data} = Shopware
const {Criteria} = Data

export default {
    template,
    data() {
        return {
            comments: null as EntitySchema.EntityCollection<'comment'>
        }
    },
    async created() {
        this.comments = await this.commentRepository.search(this.commentCriteria)
    },
    computed: {
        dateFilter() {
            return Shopware.Filter.getByName('date');
        },
        commentRepository() {
            return this.repositoryFactory.create('comment')
        },
        commentCriteria() {
            const criteria = new Criteria()
            criteria.addFilter(Criteria.equals('categoryId', this.$route.params.id))
            criteria.addFilter(Criteria.not('and', [Criteria.equals('emailVerifiedAt', null)]))
            return criteria
        },
        commentColumns(): GridColumn[] {
            return [{
                property: 'firstName',
                label: this.$t('plugin.RustyMcFly.CommentCmsPage.firstName'),
            }, {
                property: 'lastName',
                label: this.$t('plugin.RustyMcFly.CommentCmsPage.lastName'),
            }, {
                property: 'text',
                label: this.$t('plugin.RustyMcFly.CommentCmsPage.comment'),
            }, {
                property: 'active',
                inlineEdit: 'boolean',
                label: this.$t('plugin.RustyMcFly.CommentCmsPage.active'),
            }, {
                property: 'email',
                label: this.$t('plugin.RustyMcFly.CommentCmsPage.email'),
            }, {
                property: 'emailVerifiedAt',
                label: this.$t('plugin.RustyMcFly.CommentCmsPage.emailVerified'),
            }, {
                property: 'createdAt',
                label: this.$t('plugin.RustyMcFly.CommentCmsPage.createdAt'),
            }]
        }
    }
}
