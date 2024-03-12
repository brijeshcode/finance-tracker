<template>
	<thead class="bg-gray-100  text-gray-700 text-xs font-medium  uppercase tracking-wider ">
        <tr>
          <th scope="col" v-for="(th, index) in tableHeads" class="py-3 font-semibold  " :class="tableHeads.length - 1 == index  && (th.lable == 'action' || th.lable == 'Action') ? 'text-right': 'text-left' " >
            <abbr v-if="th.detail" :title="th.detail" class="cursor-help" >{{ th.label }}</abbr>
            <span v-else-if="th.label" >{{ th.label }}</span>
            <span v-else >{{ th }}</span>
          </th>
        </tr>
      </thead>
</template>

<script>
	export default{
        props: {
            tableHeads: {type: [Array, Object], default: null},
        }
    }
</script>