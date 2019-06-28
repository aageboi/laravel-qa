<script>
export default {
	props: ['answer'],

	data () {
		return {
			editing: false,
			body: this.answer.body,
			bodyHtml: this.answer.body_html,
			id: this.answer.id,
			questionId: this.answer.question_id,
			beforeEditCache: null
		}
	},

	methods: {
		editAnswer () {
			this.beforeEditCache = this.body;
			this.editing = true;
		},
		cancelAnswer () {
			this.body = this.beforeEditCache;
			this.editing = false;
		},
		updateAnswer () {
			axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
				body: this.body
			})
			.then(res => {
				this.bodyHtml = res.data.body_html;
				this.editing = false;
			})
			.catch(err => {
				console.log(err);
			});
		}
	},

	computed: {
		isInvalid () {
			return this.body.length < 10;
		}
	}
}
</script>