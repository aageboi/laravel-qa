<template>
	<div>
		<a v-if="canAccept" title="Mark this answer as best answer" :class="classes" @click.prevent="selectBest">
		    <i class="fas fa-check fa-2x"></i>
		</a>

	    <a v-if="accepted" title="The question owner accepted this answer as best answer" :class="classes">
	        <i class="fas fa-check fa-2x"></i>
	    </a>
	</div>
</template>

<script>
export default {
	props: ['answer'],

	data () {
		return {
			isBest: this.answer.is_best,
			id: this.answer.id
		}
	},

	methods: {
		selectBest () {
			axios.post(`/answers/${this.id}/accept`)
			.then(res => {
				this.$toast.success('Success', res.data.message, {
					timeout: 3000,
					position: 'topCenter'
				});

				this.isBest = true;
			})
		}
	},

	computed: {
		canAccept () {
			return this.authorize('accept', this.answer);
		},

		accepted () {
			return ! this.canAccept && this.answer.isBest;
		},

		classes () {
			return [
				'mt-2',
				this.isBest ? 'vote-accepted' : ''
			];
		}
	}
}
</script>