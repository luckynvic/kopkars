-- Function: public.trigger_cicilan_updatedeletesoftdelete()

-- DROP FUNCTION public.trigger_cicilan_updatedeletesoftdelete();

CREATE OR REPLACE FUNCTION public.trigger_cicilan_updatedeletesoftdelete()
  RETURNS trigger AS
$BODY$

DECLARE
   last_time timestamp;
BEGIN
   last_time = now();

   --Jika data dihapus catat data sebelumnya pada histori
   IF (TG_OP = 'DELETE') THEN
      IF (OLD.nomor_referensi IS NOT NULL) THEN
         INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu)
         VALUES (OLD.anggota_id, OLD.id, 'nomor_referensi', OLD.nomor_referensi, null,'DELETE', last_time);
      END IF;

      INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu)
      VALUES (OLD.anggota_id, OLD.id, 'cicilan', OLD.cicilan, null,'DELETE', last_time);

      IF (OLD.keterangan IS NOT NULL) THEN
         INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu)
         VALUES (OLD.anggota_id, OLD.id, 'keterangan', OLD.keterangan, null,'DELETE', last_time);
      END IF;

   ELSIF (TG_OP = 'UPDATE') THEN
      --Jika update data anggota_id berubah catat pada histori
      IF (NEW.anggota_id != OLD.anggota_id) THEN
         INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu,by)
         VALUES (OLD.anggota_id, OLD.id, 'anggota_id', OLD.anggota_id, NEW.anggota_id, 'UPDATE', last_time, NEW.last_update_by);
      END IF;

      --Jika update data cicilan_id berubah catat pada histori
      IF (NEW.id != OLD.id) THEN
         INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu,by)
         VALUES (OLD.anggota_id, OLD.id, 'cicilan_id', OLD.id, NEW.id, 'UPDATE', last_time, NEW.last_update_by);
      END IF;

      --Jika update data cicilan berubah catat pada histori
      IF (NEW.cicilan != OLD.cicilan) THEN
         INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu,by)
         VALUES (OLD.anggota_id, OLD.id, 'cicilan', OLD.cicilan, NEW.cicilan, 'UPDATE', last_time, NEW.last_update_by);
      END IF;

      --Jika update data is_deleted=true catat pada histori
      IF ((NEW.is_deleted != OLD.is_deleted) AND (NEW.is_deleted = TRUE)) THEN
         INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu,by)
         VALUES (OLD.anggota_id, OLD.id, 'is_deleted', OLD.is_deleted, NEW.is_deleted, 'SOFTDELETE TRUE', last_time, NEW.last_softdelete_by);
      END IF;

      --Jika update data is_deleted=false catat pada histori
      IF ((NEW.is_deleted != OLD.is_deleted) AND (NEW.is_deleted = FALSE)) THEN
         INSERT INTO histori_cicilan (anggota_id,cicilan_id,cicilan_kolom,value_old,value_new,jenis_transaksi,waktu,by)
         VALUES (OLD.anggota_id, OLD.id, 'is_deleted', OLD.is_deleted, NEW.is_deleted, 'SOFTDELETE FALSE', last_time, NEW.last_softdelete_by);
      END IF;
      
   END IF;

   RETURN NEW;
	 
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;