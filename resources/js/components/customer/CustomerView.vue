<template>
    <div class="container">
        <h1 class="text-center pt-2">Welcome to akaarIT LTD</h1>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="headerName">
                    <h3>Customer Data</h3>
                </div>
                <div class="customerAddButton">
                    <a :href="importUrl" class="btn btn-primary">Add Customer CSV</a>
                    <button class="btn btn-primary ms-2" @click="AddCustomerModal">Add Customer</button>
                </div>
            </div>
            <div class="card-body">
                <div class="success" v-if="Object.keys(customers).length > 0">
                    <div class="search-box d-flex justify-between align-items-center w-100 gap-4 mb-3">
                        <div class="branch w-50">
                            <select v-model="branch_id" @change="branchSearch" class="form-select"
                                aria-label="Default select example">
                                <option value="" disabled selected>Search Branch Wise</option>
                                <option v-for="branch in uniqueBranches" :key="branch.id" :value="branch">{{ branch }}
                                </option>
                            </select>
                        </div>
                        <div class="gender w-50">
                            <select v-model="gender" @change="genderSearch" class="form-select"
                                aria-label="Default select example">
                                <option value="" disabled selected>Search Gender Wise</option>
                                <option v-for="(gender, index) in uniquegender" :key="index" :value="gender">{{ gender
                                    }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-bordered table-hove table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Branch_id</th>
                                <th scope="col">First_name</th>
                                <th scope="col">Last_name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Gender</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in customers.data" :key="customer.id">
                                <td>{{ customer.branch_id }}</td>
                                <td>{{ customer.first_name }}</td>
                                <td>{{ customer.last_name }}</td>
                                <td>{{ customer.email }}</td>
                                <td>{{ customer.phone }}</td>
                                <td>{{ customer.gender }}</td>
                            </tr>
                            <tr>
                                <td aria-colspan="2">
                                    Total customers Count
                                </td>
                                <td aria-colspan="2">
                                    {{ totalCustomerCount }}
                                </td>
                                <td aria-colspan="2">
                                    Total Male Customer Count
                                </td>
                                <td aria-colspan="2">
                                    {{ totalMaleCustomerCount }}
                                </td>
                                <td aria-colspan="2">
                                    Total Female Customer Count
                                </td>
                                <td aria-colspan="2">
                                    {{ totalFemaleCustomerCount }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination Controls inside card-body -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <!-- Previous Button -->
                                <li class="page-item" :class="{ disabled: !customers.prev_page_url }">
                                    <a class="page-link" href="#"
                                        @click="changePage(customers.prev_page_url)">Previous</a>
                                </li>

                                <!-- Page Number Buttons (Show Pages 1 to 4) -->
                                <li v-for="page in visiblePages" :key="page"
                                    :class="{ 'active': page === customers.current_page }" class="page-item">
                                    <a class="page-link" href="#" @click="changePage(customers.path + '?page=' + page)">
                                        {{ page }}
                                    </a>
                                </li>

                                <!-- Next Button -->
                                <li class="page-item" :class="{ disabled: !customers.next_page_url }">
                                    <a class="page-link" href="#" @click="changePage(customers.next_page_url)">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div v-else class="fail">
                    <h4 class="text-center text-danger">No Customer Data Found</h4>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="editSupplierLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-3">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="editSupplierModal">
                            Add Customers
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mb-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-muted font-bold">Add Customers</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="formSubmit">
                                            <div class="mb-2">
                                                <label for="branch_id" class="form-label mb-0">Branch ID</label>
                                                <input v-model="formCustomer.branch_id" type="text" class="form-control"
                                                    id="branch_id" />
                                                <small v-if="errors.branch_id" class="text-danger">{{ errors.branch_id
                                                    }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <label for="first_name" class="form-label mb-0">First name</label>
                                                <input v-model="formCustomer.first_name" type="text"
                                                    class="form-control" id="first_name" />
                                                <small v-if="errors.first_name" class="text-danger">{{ errors.first_name
                                                    }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <label for="last_name" class="form-label mb-0">Last Name</label>
                                                <input v-model="formCustomer.last_name" type="text" class="form-control"
                                                    id="last_name" />
                                                <small v-if="errors.last_name" class="text-danger">{{ errors.last_name
                                                    }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <label for="email" class="form-label mb-0">Email</label>
                                                <input v-model="formCustomer.email" type="email" class="form-control"
                                                    id="email" />
                                                <small v-if="errors.email" class="text-danger">{{ errors.email
                                                    }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <label for="phone" class="form-label mb-0">Phone</label>
                                                <input v-model="formCustomer.phone" type="text" class="form-control"
                                                    id="phone" />
                                                <small v-if="errors.phone" class="text-danger">{{ errors.phone
                                                    }}</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="gender" class="form-label mb-0">Gender</label>
                                                <input v-model="formCustomer.gender" type="text" class="form-control"
                                                    id="gender" />
                                                <small v-if="errors.gender" class="text-danger">{{ errors.gender
                                                    }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</template>

<script>
import { onMounted, ref, computed } from 'vue'

export default {
    name: "CustomerView",
    setup() {
        const formCustomer = ref({
            branch_id: '',
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            gender: ''
        });
        const importUrl = ref('/import')
        const errors = ref({});
        const branch_id = ref('');
        const gender = ref('');
        const customers = ref({});
        const totalCustomerCount = ref(null);
        const totalMaleCustomerCount = ref(null);
        const totalFemaleCustomerCount = ref(null);
        const visiblePages = computed(() => {
            const totalPages = customers.value.last_page || 1;
            const range = [];
            const maxVisiblePages = 4;
            for (let i = 1; i <= Math.min(maxVisiblePages, totalPages); i++) {
                range.push(i);
            }
            return range;
        });

        const AddCustomerModal = () => {
            let myModal = new bootstrap.Modal(
                document.getElementById("addCustomerModal"),
                {}
            );
            myModal.show();
        }

        const fetchCustomer = async (url = '/api/customer') => {
            try {
                const response = await axios.get(url);
                if (response.data && response.status === 200) {
                    customers.value = response.data.customers;
                    totalCustomerCount.value = response.data.total_customer_count;
                    totalMaleCustomerCount.value = response.data.total_male_customer_count;
                    totalFemaleCustomerCount.value = response.data.total_female_customer_count;
                }
            } catch (error) {
                console.log(error);
            }
        };

        const branchSearch = async () => {
            const url = `/api/customer?branch_id=${branch_id.value}`;
            fetchCustomer(url);
        };
        const genderSearch = async () => {
            const url = `/api/customer?gender=${gender.value}`;
            fetchCustomer(url);
        };
        const changePage = (url) => {
            if (url) {
                let finalUrl = url;
                if (branch_id.value) {
                    finalUrl = appendParamToUrl(finalUrl, 'branch_id', branch_id.value);
                }
                if (gender.value) {
                    finalUrl = appendParamToUrl(finalUrl, 'gender', gender.value);
                }

                fetchCustomer(finalUrl);
            }
        };

        const appendParamToUrl = (url, key, value) => {
            const separator = url.includes('?') ? '&' : '?';
            return `${url}${separator}${key}=${value}`;
        };

        const uniqueBranches = computed(() => {
            if (customers.value.data) {
                return [...new Set(customers.value.data.map(customer => customer.branch_id))];
            }
            return [];
        });

        const uniquegender = computed(() => {
            if (customers.value.data) {
                return [...new Set(customers.value.data.map(customer => customer.gender))];
            }
            return [];
        });

        const formSubmit = async () => {
            try {
                const response = await axios.post('/api/customer/store', formCustomer.value);
                if (response.data && response.status === 201) {
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("addCustomerModal")
                    );
                    myModal.hide();
                    fetchCustomer();
                }
            } catch (error) {
                console.log(error)
                errors.value = error.response.data.errors;
            }
        }

        onMounted(() => {
            fetchCustomer();
        });

        return {
            customers,
            visiblePages,
            changePage,
            uniqueBranches,
            uniquegender,
            branch_id,
            branchSearch,
            genderSearch,
            gender,
            totalCustomerCount,
            totalMaleCustomerCount,
            totalFemaleCustomerCount,
            AddCustomerModal,
            formSubmit,
            formCustomer,
            errors,
            importUrl
        };
    }
}
</script>


<style scoped>
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 5px;
}

.pagination-sm .page-item .page-link {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.25;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.pagination .page-item.disabled .page-link {
    pointer-events: none;
    color: #6c757d;
}

.d-flex {
    display: flex;
}

.justify-content-center {
    justify-content: center;
}

.mt-3 {
    margin-top: 1rem;
}
</style>
