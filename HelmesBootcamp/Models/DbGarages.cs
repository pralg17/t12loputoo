using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace HelmesBootcamp.Models
{
    /// <summary>
    /// We use "Db" before car to indicat that this class is reperesantion of some table in database
    /// </summary>
    [Table("Garages")]
    public class DbGarages
    {
        public DbGarages()
        {
            this._Bookings = new HashSet<DbBooking>();
        }

        [Key]
        [DatabaseGeneratedAttribute(DatabaseGeneratedOption.Identity)]
        public int Id { get; set; }

        [Required]
        [Display(Name = "Garage")]
        [MaxLength(15, ErrorMessage = "Garage name must have 1-15 characters")]
        public string GarageName { get; set; }

        [Required]
        [Display(Name = "Address")]
        [MaxLength(200, ErrorMessage = "Address must have 1-200 characters")]
        public string Address { get; set; }

        [Required]
        [Display(Name = "Tyre hotel")]
        public bool TyreHotel { get; set; }

        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:dd.MM.yyyy HH:mm}", ApplyFormatInEditMode = true)]
        public DateTime? Deleted { get; set; }

        public virtual ICollection<DbBooking> _Bookings { get; set; }
    }
}