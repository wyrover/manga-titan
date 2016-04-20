<template>
<table class="ui basic definition table">
    <tbody v-if="remap.length > 0">
        <tr v-for="item in remap">
            <td v-text="item.label"></td>
            <td v-if="item.type=='text'" v-text="tmpdata[item.key]"></td>
            <td v-if="item.type=='rating'"><vue-desc-rating :data-desc="tmpdata[item.key]"></vue-desc-rating></td>
            <td v-if="item.type=='link'"><vue-desc-link :items="tmpdata[item.key]" :custom-class="(typeof item.class=='undefined')?[]:item.class" :format="item.format"></vue-desc-link></td>
            <td v-if="item.type=='number'">{{ tmpdata[item.key] }} {{ tmpdata[item.key] | pluralize item.pluralize }}</td>
            <td v-else></td>
        </tr>
    </tbody>
</table>
</template>

<script>
	module.exports = {
		props: {
			maps: {
				required: true,
				type: Array
			}
		},
		data: function () {
			return {
				tmpdata: {},
                remap: []
			}
		},
        events: {
            'row-flash': function (data) {
                this.tmpdata = data;
            }
        },
        ready: function () {
            this.remap = this.maps;
        }
	}
</script>