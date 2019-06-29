<template>
	<a title="Click to mark as favorite question (Click again to undo)" :class="classes" @click.prevent="toggleFav">
    	<i class="fas fa-star fa-2x"></i>
    	<span class="favorite-count">{{ count }}</span>
	</a>
</template>

<script>
export default {
	props: ['question'],

	data () {
		return {
			isFavorited: this.question.is_favorited,
			count: this.question.favorites_count,
			id: this.question.id
		}
	},

	computed: {
		classes () {
			return [
				'favorite', 'mt-2',
				! this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '')
			]
		},

		endpoint () {
			return `/questions/${this.id}/favorites`;
		}
	},

	methods: {
		toggleFav () {
			if (! this.signedIn) {
				this.$toast.warning('Please login to favorite this question', 'Warning', {
					timeout: 3000,
					position: 'topCenter'
				});
				return;
			}
			this.isFavorited ? this.destroyFav() : this.createFav();
		},

		destroyFav () {
			axios.delete(this.endpoint)
			.then(res => {
				this.count--;
				this.isFavorited = false;
			})
		},

		createFav () {
			axios.post(this.endpoint)
			.then(res => {
				this.count++;
				this.isFavorited = true;
			})
		}
	}
}
</script>