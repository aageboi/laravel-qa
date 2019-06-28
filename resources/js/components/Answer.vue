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
			axios.patch(this.endpoint, {
				body: this.body
			})
			.then(res => {
				this.bodyHtml = res.data.body_html;
				this.editing = false;
			})
			.catch(err => {
				console.log(err);
			});
		},
		destroyAnswer() {
			if (confirm('Are you sure?')) {
				axios.delete(this.endpoint)
				.then(res => {
					$(this.$el).fadeOut(500, () => {
						alert(res.data.message);
					})
				})
			}
		}
	},

	computed: {
		isInvalid () {
			return this.body.length < 10;
		},

		endpoint () {
		 	return `/questions/${this.questionId}/answers/${this.id}`
		}
	}
}
</script>