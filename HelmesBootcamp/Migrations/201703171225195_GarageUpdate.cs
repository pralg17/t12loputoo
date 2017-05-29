namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class GarageUpdate : DbMigration
    {
        public override void Up()
        {
            DropForeignKey("dbo.Booking", "GarageName", "dbo.Garages");
            DropIndex("dbo.Booking", new[] { "GarageName" });
            DropPrimaryKey("dbo.Garages");
            AlterColumn("dbo.Booking", "GarageName", c => c.String(nullable: false, maxLength: 15));
            AlterColumn("dbo.Garages", "GarageName", c => c.String(nullable: false, maxLength: 15));
            AlterColumn("dbo.Garages", "Address", c => c.String(nullable: false, maxLength: 200));
            AlterColumn("dbo.Garages", "TyreHotel", c => c.Boolean(nullable: false));
            AddPrimaryKey("dbo.Garages", "GarageName");
            CreateIndex("dbo.Booking", "GarageName");
            AddForeignKey("dbo.Booking", "GarageName", "dbo.Garages", "GarageName", cascadeDelete: true);
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.Booking", "GarageName", "dbo.Garages");
            DropIndex("dbo.Booking", new[] { "GarageName" });
            DropPrimaryKey("dbo.Garages");
            AlterColumn("dbo.Garages", "TyreHotel", c => c.String(nullable: false));
            AlterColumn("dbo.Garages", "Address", c => c.String(nullable: false));
            AlterColumn("dbo.Garages", "GarageName", c => c.String(nullable: false, maxLength: 128));
            AlterColumn("dbo.Booking", "GarageName", c => c.String(nullable: false, maxLength: 128));
            AddPrimaryKey("dbo.Garages", "GarageName");
            CreateIndex("dbo.Booking", "GarageName");
            AddForeignKey("dbo.Booking", "GarageName", "dbo.Garages", "GarageName", cascadeDelete: true);
        }
    }
}
