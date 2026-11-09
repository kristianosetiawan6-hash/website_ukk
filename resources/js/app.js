import './bootstrap';

function greetingForDeviceTime() {
	const hour = new Date().getHours();
	if (hour >= 4 && hour < 11) return 'Selamat pagi';
	if (hour >= 11 && hour < 15) return 'Selamat siang';
	if (hour >= 15 && hour < 19) return 'Selamat sore';
	return 'Selamat malam';
}

const dashboardGreeting = document.querySelector('#dashboardGreeting');
if (dashboardGreeting) dashboardGreeting.textContent = greetingForDeviceTime();

const pageTitles = {
	dashboard: 'Ringkasan',
	employees: 'Data pegawai',
	payroll: 'Penggajian',
	attendance: 'Absensi',
	reports: 'Laporan',
	settings: 'Pengaturan',
};

const sidebar = document.querySelector('#sidebar');
const scrim = document.querySelector('#sidebarScrim');
const toast = document.querySelector('#toast');
let toastTimer;

function showToast(message) {
	document.querySelector('#toastMessage').textContent = message;
	toast.classList.add('show');
	clearTimeout(toastTimer);
	toastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
}

function navigateTo(page) {
	const target = document.querySelector(`[data-page="${page}"]`);
	if (!target) return;

	document.querySelectorAll('.page-view').forEach((view) => view.classList.toggle('active', view === target));
	document.querySelectorAll('.nav-link').forEach((link) => link.classList.toggle('active', link.dataset.pageLink === page));
	document.querySelector('#breadcrumbTitle').textContent = pageTitles[page];
	sidebar.classList.remove('open');
	scrim.classList.remove('open');
	window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.querySelectorAll('[data-page-link]').forEach((link) => {
	link.addEventListener('click', (event) => {
		event.preventDefault();
		navigateTo(link.dataset.pageLink);
	});
});

document.querySelector('#menuToggle').addEventListener('click', () => {
	sidebar.classList.toggle('open');
	scrim.classList.toggle('open');
});
scrim.addEventListener('click', () => {
	sidebar.classList.remove('open');
	scrim.classList.remove('open');
});

document.querySelectorAll('[data-open-modal]').forEach((button) => {
	button.addEventListener('click', () => {
		document.querySelector(`#${button.dataset.openModal}`).classList.add('open');
	});
});
document.querySelectorAll('[data-close-modal]').forEach((button) => {
	button.addEventListener('click', () => button.closest('.modal-backdrop').classList.remove('open'));
});
document.querySelectorAll('.modal-backdrop').forEach((backdrop) => {
	backdrop.addEventListener('click', (event) => {
		if (event.target === backdrop) backdrop.classList.remove('open');
	});
});
document.addEventListener('keydown', (event) => {
	if (event.key === 'Escape') document.querySelectorAll('.modal-backdrop.open').forEach((modal) => modal.classList.remove('open'));
});

const employeeSearch = document.querySelector('#employeeSearch');
const departmentFilter = document.querySelector('#departmentFilter');
const statusFilter = document.querySelector('#statusFilter');
function filterEmployees() {
	if (!employeeSearch) return;
	const query = employeeSearch.value.trim().toLowerCase();
	const department = departmentFilter.value;
	const status = statusFilter.value;
	let visibleCount = 0;

	document.querySelectorAll('#employeeTable tr').forEach((row) => {
		const matches = `${row.dataset.name} ${row.textContent}`.toLowerCase().includes(query)
			&& (!department || row.dataset.department === department)
			&& (!status || row.dataset.status === status);
		row.hidden = !matches;
		if (matches) visibleCount += 1;
	});
	document.querySelector('#emptyEmployees').style.display = visibleCount ? 'none' : 'block';
}
employeeSearch?.addEventListener('input', filterEmployees);
departmentFilter?.addEventListener('change', filterEmployees);
statusFilter?.addEventListener('change', filterEmployees);

function formatRupiah(value) {
	return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(Number(value));
}

function parseCsv(text) {
	const content = text.replace(/^\uFEFF/, '').trim();
	if (!content) throw new Error('File CSV kosong.');
	const firstLine = content.split(/\r?\n/, 1)[0];
	const delimiter = firstLine.split(';').length > firstLine.split(',').length ? ';' : ',';
	const records = [];
	let record = [];
	let field = '';
	let quoted = false;

	for (let index = 0; index < content.length; index += 1) {
		const character = content[index];
		if (character === '"' && quoted && content[index + 1] === '"') {
			field += '"';
			index += 1;
		} else if (character === '"') {
			quoted = !quoted;
		} else if (character === delimiter && !quoted) {
			record.push(field);
			field = '';
		} else if ((character === '\n' || character === '\r') && !quoted) {
			record.push(field);
			if (record.some((value) => value.trim())) records.push(record);
			record = [];
			field = '';
			if (character === '\r' && content[index + 1] === '\n') index += 1;
		} else {
			field += character;
		}
	}
	if (quoted) throw new Error('Format kutip pada file CSV tidak valid.');
	record.push(field);
	if (record.some((value) => value.trim())) records.push(record);
	if (records.length < 2) throw new Error('Dataset harus memiliki header dan minimal satu baris pegawai.');

	const headers = records[0].map((value) => value.toLowerCase().replace(/[^a-z0-9]/g, ''));
	const findColumn = (...names) => headers.findIndex((header) => names.includes(header));
	const nameColumn = findColumn('nama', 'namapegawai', 'name', 'employeename');
	const salaryColumn = findColumn('gajipokok', 'salary', 'basicsalary');
	const allowanceColumn = findColumn('tunjangan', 'allowance');
	const deductionColumn = findColumn('potongan', 'deduction');
	if (nameColumn < 0 || salaryColumn < 0) throw new Error('Header wajib: nama dan gaji_pokok.');

	const amount = (value, label, rowNumber, required = false) => {
		const raw = value?.trim() ?? '';
		if (!raw && !required) return 0;
		const parsed = Number(raw.replace(/[^\d-]/g, ''));
		if (!raw || !Number.isFinite(parsed) || parsed < 0) throw new Error(`${label} pada baris ${rowNumber} tidak valid.`);
		return parsed;
	};
	return records.slice(1).map((row, index) => {
		const name = row[nameColumn]?.trim();
		if (!name) throw new Error(`Nama pegawai pada baris ${index + 2} belum diisi.`);
		const basicSalary = amount(row[salaryColumn], 'Gaji pokok', index + 2, true);
		const allowance = allowanceColumn < 0 ? 0 : amount(row[allowanceColumn], 'Tunjangan', index + 2);
		const deduction = deductionColumn < 0 ? 0 : amount(row[deductionColumn], 'Potongan', index + 2);
		if (deduction > basicSalary + allowance) throw new Error(`Potongan melebihi gaji pada baris ${index + 2}.`);
		return { name, basicSalary, allowance, deduction, netSalary: basicSalary + allowance - deduction };
	});
}

let payrollDataset = null;
const payrollDatasetInput = document.querySelector('#payrollDataset');
payrollDatasetInput?.addEventListener('change', async (event) => {
	const file = event.currentTarget.files[0];
	const confirmButton = document.querySelector('#confirmPayroll');
	const status = document.querySelector('#datasetStatus');
	payrollDataset = null;
	confirmButton.disabled = true;
	status.classList.remove('error');
	document.querySelector('#datasetEmployeeCount').textContent = '-';
	document.querySelector('#datasetPayrollTotal').textContent = '-';
	if (!file) return;
	document.querySelector('#datasetFileName').textContent = file.name;

	try {
		if (!file.name.toLowerCase().endsWith('.csv')) throw new Error('Pilih file dengan format .csv.');
		const employees = parseCsv(await file.text());
		payrollDataset = { employees, total: employees.reduce((sum, employee) => sum + employee.netSalary, 0) };
		document.querySelector('#datasetEmployeeCount').textContent = `${employees.length} orang`;
		document.querySelector('#datasetPayrollTotal').textContent = `Rp${formatRupiah(payrollDataset.total)}`;
		status.textContent = 'Dataset valid. Total dihitung dari gaji pokok + tunjangan - potongan.';
		confirmButton.disabled = false;
	} catch (error) {
		status.textContent = error.message;
		status.classList.add('error');
	}
});

document.querySelector('#employeeForm')?.addEventListener('submit', (event) => {
	event.preventDefault();
	const form = new FormData(event.currentTarget);
	const name = form.get('name').trim();
	const department = form.get('department');
	const salary = form.get('salary');
	const joinDate = new Date(`${form.get('joinDate')}T00:00:00`);
	const dateLabel = new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(joinDate);
	const employeeId = `EMP-${String(Number(document.querySelector('#employeeCount').textContent) + 1).padStart(4, '0')}`;
	const initials = name.split(/\s+/).slice(0, 2).map((part) => part[0]).join('').toUpperCase();
	const row = document.createElement('tr');
	row.dataset.name = name.toLowerCase();
	row.dataset.department = department;
	row.dataset.status = 'Aktif';
	row.innerHTML = `<td><div class="person-cell"><div class="avatar">${initials}</div><span><strong></strong><small>${employeeId}</small></span></div></td><td></td><td>${dateLabel}</td><td>Rp${formatRupiah(salary)}</td><td><span class="status">Aktif</span></td><td><button class="row-menu" aria-label="Opsi pegawai">···</button></td>`;
	row.querySelector('.person-cell strong').textContent = name;
	row.children[1].textContent = department;
	document.querySelector('#employeeTable').prepend(row);
	document.querySelector('#employeeCount').textContent = Number(document.querySelector('#employeeCount').textContent) + 1;
	document.querySelector('#employeeCountSecondary').textContent = document.querySelector('#employeeCount').textContent;
	document.querySelector('#employeeModal').classList.remove('open');
	event.currentTarget.reset();
	document.querySelector('#employeeJoinDate').value = '2026-09-30';
	showToast(`${name} berhasil ditambahkan ke direktori pegawai.`);
});

document.querySelector('#confirmPayroll')?.addEventListener('click', async (event) => {
	if (!payrollDataset) return;
	const confirmButton = event.currentTarget;
	confirmButton.disabled = true;
	let result;
	try {
		const response = await fetch('/payroll/process', {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
			},
			body: JSON.stringify({
				period: 'September 2026',
				employees: payrollDataset.employees.map((employee) => ({
					name: employee.name,
					basic_salary: employee.basicSalary,
					allowance: employee.allowance,
					deduction: employee.deduction,
				})),
			}),
		});
		result = await response.json();
		if (!response.ok) throw new Error(result.message || 'Penggajian gagal diproses.');
	} catch (error) {
		confirmButton.disabled = false;
		showToast(error.message);
		return;
	}
	const formattedTotal = `Rp${formatRupiah(result.total)}`;
	document.querySelector('#payrollModal').classList.remove('open');
	document.querySelector('#processButtonLabel').textContent = 'Penggajian diproses';
	document.querySelector('#payrollStatus').textContent = 'Selesai';
	document.querySelector('#payrollPeriodTotal').textContent = formattedTotal;
	document.querySelector('#payrollPeriodCount').textContent = `${result.count} orang`;
	const currentPeriod = document.querySelector('#payrollHistory tr');
	currentPeriod.cells[0].querySelector('strong').textContent = result.period;
	currentPeriod.cells[1].textContent = `${result.count} orang`;
	currentPeriod.cells[2].textContent = formattedTotal;
	const status = document.querySelector('#payrollHistoryStatus');
	status.textContent = 'Selesai';
	status.classList.remove('leave');
	showToast(`Penggajian ${result.period} untuk ${result.count} pegawai berhasil diproses.`);
});

function reportData(reportType = '') {
	const activePage = document.querySelector('.page-view.active').dataset.page;
	if (reportType === 'attendance' || activePage === 'attendance') {
		const cards = [...document.querySelectorAll('.page-view.active .stats-grid .stat-card')];
		return {
			title: 'Laporan Absensi',
			headers: ['Indikator', 'Jumlah', 'Keterangan'],
			rows: cards.map((card) => [
				card.querySelector('.stat-top').childNodes[0].textContent.trim(),
				card.querySelector('.stat-value').innerText.trim(),
				card.querySelector('.stat-foot').innerText.trim(),
			]),
		};
	}

	const isPayroll = reportType === 'payroll' || reportType === 'costs' || activePage === 'payroll' || (activePage === 'reports' && !reportType);
	const table = document.querySelector(isPayroll ? '#payrollHistory' : activePage === 'dashboard' ? '#recentEmployees' : '#employeeTable');
	const headers = [...table.closest('table').querySelectorAll('thead th')].map((cell) => cell.innerText.trim());
	const includedColumns = reportType === 'costs'
		? [0, 2]
		: reportType === 'employees'
			? [0, 1, 2, 3, 4, 5]
			: headers.map((value, index) => value ? index : -1).filter((index) => index >= 0);
	const rows = [...table.querySelectorAll('tr')]
		.filter((row) => !row.hidden)
		.map((row) => includedColumns.map((index) => row.cells[index]?.innerText.trim().replaceAll('\n', ' ') ?? ''));
	const outputHeaders = reportType === 'costs' ? ['Periode', 'Biaya tenaga kerja'] : includedColumns.map((index) => headers[index]);
	return {
		title: reportType === 'costs' ? 'Analisis Biaya SDM' : isPayroll ? 'Laporan Penggajian' : 'Direktori Pegawai',
		headers: outputHeaders,
		rows,
	};
}

function escapeXml(value) {
	return String(value).replace(/[<>&"']/g, (character) => ({
		'<': '&lt;',
		'>': '&gt;',
		'&': '&amp;',
		'"': '&quot;',
		"'": '&apos;',
	})[character]);
}

document.querySelectorAll('[data-export]').forEach((button) => {
	button.addEventListener('click', () => {
		const data = reportData(button.dataset.export);
		const spreadsheetRows = [data.headers, ...data.rows].map((row, index) => `<Row>${row.map((value) => `<Cell${index === 0 ? ' ss:StyleID="Header"' : ''}><Data ss:Type="String">${escapeXml(value)}</Data></Cell>`).join('')}</Row>`).join('');
		const workbook = `<?xml version="1.0"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"><Styles><Style ss:ID="Header"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#244B3B" ss:Pattern="Solid"/></Style></Styles><Worksheet ss:Name="${escapeXml(data.title.slice(0, 31))}"><Table>${spreadsheetRows}</Table></Worksheet></Workbook>`;
		const url = URL.createObjectURL(new Blob([workbook], { type: 'application/vnd.ms-excel;charset=utf-8' }));
		const link = document.createElement('a');
		link.href = url;
		link.download = `${data.title.toLowerCase().replaceAll(' ', '-')}.xls`;
		link.click();
		URL.revokeObjectURL(url);
		showToast('Laporan Excel berhasil diunduh.');
	});
});

document.querySelectorAll('[data-print]').forEach((button) => {
	button.addEventListener('click', () => {
		const data = reportData();
		const printWindow = window.open('', '_blank');
		if (!printWindow) {
			showToast('Izinkan pop-up untuk mencetak laporan PDF.');
			return;
		}

		const printDocument = printWindow.document;
		printDocument.title = data.title;
		printDocument.head.innerHTML = '<meta charset="utf-8"><style>body{font:12px Arial,sans-serif;color:#23342b;padding:36px}h1{font-size:22px;margin:0 0 6px}p{color:#69776e;margin:0 0 24px}.brand{font-size:11px;font-weight:bold;letter-spacing:1px;color:#52705e;margin-bottom:36px}table{border-collapse:collapse;width:100%}th,td{border:1px solid #dce3dc;padding:9px;text-align:left}th{background:#244b3b;color:#fff;font-size:10px;text-transform:uppercase}tr:nth-child(even){background:#f4f7f2}@page{size:A4 landscape;margin:14mm}@media print{body{padding:0}}</style>';
		const heading = printDocument.createElement('h1');
		heading.textContent = data.title;
		const brand = printDocument.createElement('div');
		brand.className = 'brand';
		brand.textContent = 'RUANG GAJI  /  PEOPLE & PAYROLL';
		const description = printDocument.createElement('p');
		description.textContent = `Dicetak ${new Intl.DateTimeFormat('id-ID', { dateStyle: 'long' }).format(new Date())}`;
		const table = printDocument.createElement('table');
		const head = printDocument.createElement('thead');
		const headerRow = printDocument.createElement('tr');
		data.headers.forEach((value) => {
			const cell = printDocument.createElement('th');
			cell.textContent = value;
			headerRow.append(cell);
		});
		head.append(headerRow);
		const body = printDocument.createElement('tbody');
		data.rows.forEach((row) => {
			const tableRow = printDocument.createElement('tr');
			row.forEach((value) => {
				const cell = printDocument.createElement('td');
				cell.textContent = value;
				tableRow.append(cell);
			});
			body.append(tableRow);
		});
		table.append(head, body);
		printDocument.body.replaceChildren(brand, heading, description, table);
		printWindow.focus();
		printWindow.print();
	});
});
document.querySelector('#notificationButton').addEventListener('click', () => showToast('Anda memiliki 8 pengajuan yang menunggu persetujuan.'));
document.querySelector('#settingsButton')?.addEventListener('click', () => showToast('Pengaturan perusahaan siap dikelola.'));
