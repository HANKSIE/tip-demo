<template>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">打賞彈窗</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>
        <div class="modal-body">
            <form id="form" method="post" :action="action">
                <div class="form-group">
                    <select
                        name="store_id"
                        required
                        v-model="selected.storeId"
                        @change="loadStoreOptions(selected.storeId)"
                    >
                        <option disabled value="">店家名稱</option>
                        <option
                            v-for="store in options.stores"
                            :value="store.id"
                            :key="store.id"
                        >
                            {{ store.name }}
                        </option>
                    </select>
                    <select name="employee_id" v-model="selected.employeeId">
                        <option disabled value="">員工名稱</option>
                        <option
                            v-for="employee in options.employees"
                            :value="employee.id"
                            :key="employee.id"
                        >
                            {{ employee.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>打賞金額</label>
                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        required
                        v-model="selected.amount"
                    />
                    <div>
                        <span
                            class="badge text-bg-primary"
                            v-for="(amount, i) in options.amounts"
                            :key="i"
                            @click="useDefaultAmount(amount)"
                        >
                            {{ amount }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <select name="pay" required v-model="selected.pay">
                        <option disabled value="">支付方式</option>
                        <option value="1">信用卡</option>
                        <option value="2">Line Pay</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>評價分數</label>
                    <div v-for="score in 5" :key="score">
                        <input
                            type="radio"
                            name="score"
                            required
                            :id="`rate-${score}`"
                            v-model="selected.score"
                            :value="score"
                        />
                        <label :for="`rate-${score}`">{{ score }}顆星</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>評價</label>
                    <input
                        type="text"
                        class="form-control"
                        name="comment"
                        required
                        v-model="selected.comment"
                    />
                    <div>
                        <span
                            class="badge text-bg-primary"
                            v-for="(comment, i) in options.comments"
                            :key="i"
                            @click="useDefaultComment(comment)"
                        >
                            {{ comment }}
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" form="form" class="btn btn-primary">
                送出
            </button>
        </div>
    </div>
</template>
<script>
import { apiUrl } from "../constant";

const createInitSelected = () => ({
    storeId: "",
    employeeId: "",
    pay: "",
    amount: 0,
    score: 0,
    comment: "",
});

export default {
    data() {
        return {
            options: {
                stores: [],
                employees: [],
                amounts: [],
                comments: [],
            },
            selected: createInitSelected(),
            action: `${apiUrl}/tip`,
        };
    },
    methods: {
        // submit(e) {
        //     const formData = new FormData(e.target);
        //     for (const pair of formData.entries()) {
        //         console.log(`${pair[0]}, ${pair[1]}`);
        //     }
        //     http.post("tip", formData);
        // },
        async loadStoreOptions(id) {
            this.clear(id);
            const res = await http.get(`store/${id}/options`);
            this.options.employees = res.data.employees;
            this.options.amounts = res.data.amounts;
            this.options.comments = res.data.comments;
        },
        clear(id) {
            this.selected = createInitSelected();
            this.selected.storeId = id; // 保留現在選擇的store id
        },
        useDefaultComment(text) {
            this.selected.comment = text;
        },
        useDefaultAmount(amount) {
            this.selected.amount = amount;
        },
    },
    async created() {
        const res = await http.get("stores");
        this.options.stores = res.data.stores;
    },
};
</script>

<style></style>
