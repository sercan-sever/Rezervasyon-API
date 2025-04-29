<h1 align="center">Rezervasyon API</h1>

###

<h2 align="left">GÖREVLER VE KURALLAR</h2>

###

<h3 align="left">Görev 1: Rezervasyonlar Rezervasyonlar için, ekleme / silme / listeleme işlemlerinin gerçekleştirilebileceği bir RESTful API servisi oluşturun.</h3>

###

<h4 align="left">Rezervasyon Ekleme Kuralları Nedir?<br>Yeni rezervasyon eklenirken, otel konsepti satışa değilse (concepts.open_for_sale) bir hata mesajı döndürün. Payload validasyonu gerçekleştirin.</h4>

###

<h3 align="left">Görev 2: İndirimler<br>Verilen rezervasyonlar için indirimleri hesaplayan bir RESTful API servisi oluşturun.</h3>

###

<h4 align="left">İndirim Kuralları Nedir?<br>- Toplam 20000TL ve üzerinde rezervasyon yapan bir müşteri, rezervasyonun tamamından %10 indirim uygulanır.<br>- 1 ID'li bölgeye (district) ait bir otelden herhangi bir konseptte 7 veya daha fazla gece için rezervasyon yapıldığında, bir gece ücretsiz olarak tanımlanır.<br>- 2 ID'li bölgeden (district) 2 veya daha fazla gece için rezervasyon yapıldığında, en ucuz konseptine %25 indirim uygulanır.<br>- 3 ID'li bölgeden (district) 4 veya daha fazla gece için rezervasyon yapıldığında, %10 indirim uygulanır.</h4>

###

<h2 align="left">PROJE İÇERİSİNDE KULLANILANLAR</h2>

###

<h4 align="left">- PHP sürüm : PHP v8.3.3-1<br><br>- Laravel sürüm : Laravel v10.46.0 <br><br>- Laravel sail ile docker üzerinde çalıştırılarak gerçekleştirildi ve laravel passport kullanıldı.<br><br>- Log görüntülemeleri için log-viewer paketi.<br><br>- Mail ve Cache yapısı için Redis.<br><br>- Kuyrukları izleyebilmek için Horizon.<br><br>- Cache yapısını görüntüleyebilmek için de RedisInsight.<br><br>- Kullanıcıları yetkilendirmek için  spatie/laravel-permission paketi.</h4>

###
