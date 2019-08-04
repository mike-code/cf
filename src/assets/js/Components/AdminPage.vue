<template>
<div class="admin_page"><a-spin :spinning="loading"><a-row type="flex" justify="center"><a-col :span="12">
	<h3>Admin Page</h3>

	<a-list :dataSource="items">
		<a-list-item slot="renderItem" slot-scope="item, index">
			<a-list-item-meta :description="item.desc">
				<a slot="title">{{ item.title }} ({{ item.loan }})</a>
				<a-avatar slot="avatar" :src="`https://api.adorable.io/avatars/48/${item.title}`" />
			</a-list-item-meta>
			<div><a-button @click="getSchedule(index)">Payment schedule</a-button></div>
		</a-list-item>
	</a-list>

</a-col></a-row></a-spin>

<a-modal :title="'Payment schedule for ' + schedule.name" :visible="!!schedule.name" @ok="close" @cancel="close">
	<template slot="footer">
		<a-button key="submit" type="primary" @click="close">Close</a-button>
	</template>

	<a-list :dataSource="schedule.repayment">
		<a-list-item slot="renderItem" slot-scope="item, index">{{ item.month }} — ${{ item.amount }}</a-list-item>
		<div slot="footer"><b>Total: {{ schedule.total }}</b></div>
	</a-list>
</a-modal>
</div>
</template>

<script>
	import axios from 'axios'
	import _ from 'lodash'
	import faker from 'faker'

	export default
	{
		props: ['loan_data'],

		data() {
			return {
				loading: false,
				schedule: {},
			}
		},

		computed: {
			items() {
				let parsed = JSON.parse(this.loan_data)

				return _.map(parsed, (i) => {
					return {
						title: `${i[0]} ${i[1]}`,
						desc:  `${i[2]} ${i[3]} ${i[4]}`,
						loan:  `$${i[5]} for ${i[6]} months`
					}
				})
			}
		},

		methods: {
			close() {
				this.schedule = {}
			},

			getSchedule(idx) {
				this.loading = true

				axios.get('/schedule/' + idx)
					.then(({data}) => {
						this.schedule = data
					})
					.catch((err) => {
						this.$notification['error']({message: 'Could not fetch payment schedule', style: {top: "48px"}})
					})
					.finally(() => { this.loading = false })
			},
		}
	}
</script>
