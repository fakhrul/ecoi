# Environment
- Use XAMPP with PHP version 5.4.4. Download [here](https://jaist.dl.sourceforge.net/project/xampp/XAMPP%20Windows/5.5.19/xampp-win32-5.5.19-0-VC11-installer.exe)
- git clone this project in C:\xampp\htdocs

# Import Database
```
mysql -u root -p ecoi_rtu < "C:\Temp\ecoi-db-140721\ecoi-db-140721.sql"
```

# Accessing RTU Melaka
````
Setup

1. Pergi "Open Network and internet settings", click masuk
2. Selepas screen keluar, pilih "VPN"
3. Click "Add a VPN connection"
4. Screen add VPN akan keluar, pilih dan masuk seperti bawah
	a. VPN Provider, Pilih "Windows (built-in)
	b. Connection name, letak apa apa nama saja
	c. Server name or address, masukkan "###.###.###.###"
	d. VPN Type, pilih "pptp"
	e. Type of sign in info, pilih "User name and password"
	f. User name, masukkan "###"
	g. passwork, masukkan "###"
5. Click OK

Guna

1. Click network dan pilih nama tadi dan click connect
2. Tunggu semua jalan ok, sepatut awak akan nampak connected
3. Guna Remote desktop dalam windows, masukkan 10.1.1.1 dan click connect
4. Satu screen login akan keluar, masukkan username : linaro, password : ###, lepas itu click OK
5. you are in the system

utk web, it ada di dalam /var/www/html

ecoi user password
Usernamr : ###
Password : ###
````
