import { Controller } from '@hotwired/stimulus';
// @ts-ignore
import {DataTable} from "simple-datatables";

export default class extends Controller {
    connect() {

        const myTable = document.querySelector(".table");

        const dataTable = new DataTable(myTable, {
            perPage: 6,
            perPageSelect: [6, 12, 24]
        });
    }
}